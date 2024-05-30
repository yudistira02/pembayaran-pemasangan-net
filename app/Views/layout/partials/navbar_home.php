        <nav id="navbar" class="w-full h-[100px] bg-white items-center flex justify-between px-32 shadow-lg fixed transition duration-500">
            <div class="animate-slide-left-to-right font-bold text-4xl text-gray-800 uppercase">
                <a href="<?= base_url('/') ?>">
                    <?= env('APP_NAME') ?><span class="font-bold text-4xl text-sky-500">.</span>
                </a>
            </div>
            <div class="animate-slide-right-to-left flex items-center text-xl text-gray-700">
                <ul class="flex gap-10 text-xl font-semibold mr-10">
                    <li class="hover:text-sky-500 transition-colors duration-300">
                        <a href="<?= base_url('/') ?>">Home</a>
                    </li>
                    <li class="hover:text-sky-500 transition-colors duration-300">
                        <a href="<?= base_url('paket') ?>">Paket</a>
                    </li>
                    <li class="hover:text-sky-500 transition-colors duration-300">
                        <a href="<?= base_url('informasi') ?>">Informasi</a>
                    </li>
                    <?php if (session()->userType === 'pelanggan' and session()->pelanggan === false) : ?>
                        <li class="hover:text-yellow-500 text-yellow-400 transition-colors duration-300 animate-pulse">
                            <a href="<?= base_url('home/lengkapi/informasi/' . session()->id) ?>">Lengkapi Informasi Anda</a>
                        </li>
                    <?php endif ?>
                </ul>
                <?php if (session()->userType === 'pelanggan') : ?>
                    <div class="flex justify-center items-center cursor-pointer" x-data="{ open: false }">
                        <div class="bg-sky-500 rounded-2xl w-full text-white p-3 transition-colors duration-300 border-2 border-sky-500 hover:bg-white hover:text-black hover:border-2 hover:border-black">
                            <div class="flex justify-between items-center gap-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <h1 class="font-semibold"><?= session()->name ?></h1>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 hover:origin-center hover:rotate-180 duration-300" @click="open = !open">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                </svg>
                            </div>
                            <div class="absolute bg-white shadow-xl border-black rounded-lg p-5 m-5 mt-10" x-show="open" x-transition>
                                <?php if (session()->userType === 'pelanggan' and session()->pelanggan === false) : ?>
                                    <a href="<?= base_url('home/lengkapi/informasi/' . session()->id) ?>" class="font-semibold animate-pulse">
                                        <div class="rounded-lg transition-colors duration-300 hover:bg-gray-600 bg-gray-700 p-2 flex justify-between items-center text-white">
                                            Lengkapi Informasi
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-10 w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                        </div>
                                    </a>
                                <?php elseif (session()->userType === 'pelanggan') : ?>
                                    <a href="<?= base_url('home/profile/' . session()->id) ?>" class="font-semibold">
                                        <div class="rounded-lg transition-colors duration-300 hover:bg-gray-600 bg-gray-700 p-2 flex justify-between items-center text-white">
                                            Account
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-10 w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                        </div>
                                    </a>
                                    <a href="<?= base_url('home/laporan/saya/' . session()->id) ?>" class="font-semibold">
                                        <div class="rounded-lg transition-colors duration-300 hover:bg-gray-600 bg-gray-700 p-2 mt-5 flex justify-between items-center text-white">
                                            Lapor
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-10 w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                            </svg>
                                        </div>
                                    </a>
                                    <a href="<?= base_url('home/transaksi/saya/' . session()->id) ?>" class="font-semibold">
                                        <div class="rounded-lg transition-colors duration-300 hover:bg-gray-600 bg-gray-700 p-2 mt-5 flex justify-between items-center text-white">
                                            Transaksi Saya
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-10 w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                            </svg>
                                        </div>
                                    </a>
                                <?php endif ?>
                                <a href="#" class="font-semibold" id="logout">
                                    <div class="rounded-lg transition-colors duration-300 hover:bg-red-600 bg-red-500 p-2 mt-5 flex justify-between items-center text-white">
                                        Logout
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-10 w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <a href="<?= base_url('login') ?>" class="font-semibold transition-all duration-300 hover:bg-sky-500 py-2 px-5 rounded-full text-sky-500 hover:text-white border-2 border-sky-500 mr-10">
                        Masuk
                    </a>
                    <a href="<?= base_url('register') ?>" class="font-semibold transition-all duration-300 bg-sky-500 hover:bg-white border-2 border-sky-500 py-2 rounded-full text-white hover:text-sky-500 px-5">
                        Daftar Sekarang
                    </a>
                <?php endif ?>
            </div>
        </nav>