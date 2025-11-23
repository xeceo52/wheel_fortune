<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Колесо Фортуны</title>

    @vite(['resources/css/app.css', 'resources/js/wheel.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-slate-50 flex items-center justify-center">

<div class="w-full max-w-xl px-4 py-8">
    <div class="bg-slate-900/70 border border-slate-700/70 rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.6)] backdrop-blur-xl p-6 sm:p-8">

        <!-- Бейдж студии -->
        <div class="flex justify-center mb-3">
            <div class="px-4 py-1 rounded-full border border-slate-700 bg-slate-800/80 text-[0.65rem] sm:text-xs tracking-[0.35em] uppercase text-slate-200">
                LIGLANCE
            </div>
        </div>

        <!-- Заголовок -->
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">
                Колесо Фортуны
            </h1>
        </div>

        <!-- Колесо -->
        <div class="relative mx-auto max-w-xs sm:max-w-sm md:max-w-md aspect-square">
            <!-- Стрелка -->
            <div
                class="absolute -top-3 sm:-top-4 left-[54%] -translate-x-1/2 z-20"
                style="
                    width: 0;
                    height: 0;
                    border-left: 18px solid transparent;
                    border-right: 18px solid transparent;
                    border-top: 28px solid #ef4444;
                "
            ></div>

            <!-- Подложка под колесо -->
            <div class="absolute inset-3 sm:inset-4 rounded-full bg-slate-900/60 shadow-inner"></div>

            <!-- Сам canvas -->
            <div class="relative z-10 flex items-center justify-center h-full">
                <canvas
                    id="wheelCanvas"
                    width="400"
                    height="400"
                    class="w-full h-full"
                ></canvas>
            </div>
        </div>

        <!-- Кнопка -->
        <div class="mt-6 sm:mt-8 flex flex-col items-center gap-3">
            <button
                id="spinBtn"
                class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-blue-500 hover:bg-blue-600 active:scale-[0.98] transition
                       shadow-lg shadow-blue-500/30 text-base sm:text-lg font-semibold"
            >
                Крутить!
            </button>

            <p class="text-xs text-slate-400">
                Один клик — один шанс на приз
            </p>
        </div>

        <!-- Результат -->
        <p
            id="result"
            class="mt-6 text-center text-lg sm:text-xl font-semibold text-emerald-300 min-h-[2.5rem]"
        ></p>

        <!-- Небольшой футер-лейбл -->
        <div class="mt-4 text-center">
            <span class="text-[0.7rem] sm:text-xs text-slate-500">
                © {{ date('Y') }} LIGLANCE Studio
            </span>
        </div>
    </div>
</div>

</body>
</html>
