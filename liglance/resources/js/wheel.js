// Порядок секторов по часовой стрелке, начиная с того,
// который ДОЛЖЕН быть под стрелкой при угле 0
const segments = [
    "Подарок",            // под стрелкой при angle = 0
    "Скидка 5%",
    "Скидка 10%",
    "Скидка 15%",
    "Сертификат 500р",
    "Сертификат 1000р"
];

const colors = [
    "#34d399",
    "#f87171",
    "#fb923c",
    "#fbbf24",
    "#60a5fa",
    "#a78bfa"
];

const canvas = document.getElementById("wheelCanvas");
const ctx = canvas.getContext("2d");

const cx = 200;
const cy = 200;
const r  = 200;

let currentAngle = 0; // текущее вращение колеса в градусах

// ---------------------------------------
// РИСУЕМ КОЛЕСО: сектор 0 строго под стрелкой
// ---------------------------------------
function drawWheel() {
    const count = segments.length;
    const segAngle = (2 * Math.PI) / count;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < count; i++) {
        // Задаём УГОЛ ЦЕНТРА сектора i.
        // -Math.PI/2 = вверх (под стрелкой)
        const centerAngle = -Math.PI / 2 + segAngle * i;
        const startAngle  = centerAngle - segAngle / 2;
        const endAngle    = centerAngle + segAngle / 2;

        // Сектор
        ctx.beginPath();
        ctx.fillStyle = colors[i];
        ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, r, startAngle, endAngle);
        ctx.closePath();
        ctx.fill();

        // Текст по центру сектора
        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(centerAngle);
        ctx.textAlign = "right";
        ctx.fillStyle = "#111";
        ctx.font = "18px sans-serif";
        ctx.fillText(segments[i], r - 20, 0);
        ctx.restore();
    }
}

drawWheel();
canvas.style.transform = "rotate(0deg)";

// ---------------------------------------
// АНИМАЦИЯ
// ---------------------------------------
document.getElementById("spinBtn").addEventListener("click", async () => {
    const res = await fetch("/spin", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    });

    const data = await res.json();

    const count = segments.length;
    const segAngleDeg = 360 / count;

    // Какой сектор на колесе соответствует призу
    const indexOnWheel = segments.indexOf(data.prize);
    if (indexOnWheel === -1) {
        console.error("Приз с бэка не найден в segments:", data.prize);
        return;
    }

    // небольшой рандом внутри сектора
    const margin = 5;                       // отступ от края сектора
    const maxOffset = segAngleDeg / 2 - margin;
    const offsetFromCenter = (Math.random() * 2 - 1) * maxOffset;

    // БАЗОВЫЙ угол, при котором нужный сектор стоит под стрелкой
    // (pointer сверху, сектор 0 под ним при angle = 0)
    const baseAlignAngle = -indexOnWheel * segAngleDeg - offsetFromCenter;
    // baseAlignAngle определяет положение по модулю 360°

    // хотим хотя бы 4 полных оборота поверх текущего положения
    const minExtraSpins = 4;
    const neededSpins = Math.ceil((currentAngle - baseAlignAngle) / 360) + minExtraSpins;

    // конечный угол: тот же baseAlignAngle (по mod 360) + целое число оборотов
    const targetAngle = baseAlignAngle + 360 * neededSpins;

    const startAngle = currentAngle;
    const deltaAngle = targetAngle - startAngle;
    const duration = 3000;

    let startTime = null;

    function animate(time) {
        if (!startTime) startTime = time;
        const t = (time - startTime) / duration;
        const progress = Math.min(t, 1);
        const eased = 1 - Math.pow(1 - progress, 3); // ease-out

        const angle = startAngle + deltaAngle * eased;
        canvas.style.transform = `rotate(${angle}deg)`;

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            currentAngle = angle; // запоминаем полный угол, не по mod 360
            canvas.style.transform = `rotate(${currentAngle}deg)`;
            document.getElementById("result").textContent =
                "Вы выиграли: " + data.prize;
        }
    }

    requestAnimationFrame(animate);
});
