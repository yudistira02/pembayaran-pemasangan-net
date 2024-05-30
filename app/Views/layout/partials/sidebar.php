<div class="flex" x-data="{ open: true }">
    <div class="p-5 min-h-screen w-[250px] bg-gray-800 text-white" x-show="open" x-transition:enter="transition-transform ease-out duration-300 transform" x-transition:enter-start="translate-x-[-250px]" x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform ease-in duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-[-250px]">
        <div class="flex justify-center items-center mb-10">
            <div>
                <a href="<?= base_url('dashboard') ?>" class="font-bold text-2xl">
                    <?= env('APP_NAME') ?><span class="font-bold text-6xl text-sky-500">.</span>
                </a>
            </div>
        </div>
        <div class="flex justify-center items-center cursor-pointer" x-data="{ open: false }">
            <div class="bg-gray-100 rounded-lg w-full text-gray-700 p-3 transition-colors duration-300 hover:bg-gray-700 hover:text-white">
                <div class="flex justify-between items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <h1 class="font-semibold"><?= session()->name ?></h1>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 hover:origin-center hover:rotate-180 duration-300" @click="open = !open">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </div>
                <a href="<?= base_url('dashboard/profile/' . session()->id) ?>" class="font-semibold">
                    <div class="rounded-lg transition-colors duration-300 hover:bg-sky-600 bg-sky-500 p-2 mt-5 flex justify-between items-center text-white" x-show="open" x-transition>
                        Account
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                </a>
                <a href="#" class="font-semibold" id="logout">
                    <div class="rounded-lg transition-colors duration-300 hover:bg-red-600 bg-red-500 p-2 mt-2 flex justify-between items-center text-white" x-show="open" x-transition>
                        Logout
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
        <div class="flex justify-center items-center py-10">
            <ul class="block text-medium font-semibold w-full" x-data="{ open: false }">
                <a href="<?= base_url('dashboard') ?>">
                    <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </li>
                </a>
                <?php if (session()->userType === 'teknisi') : ?>
                    <a href="<?= base_url('dashboard/jadwal') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/jadwal')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            Jadwal
                        </li>
                    </a>
                <?php endif ?>
                <?php if (session()->userType === 'admin') : ?>
                    <a href="<?= base_url('dashboard/jadwal') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/jadwal')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            Jadwal
                        </li>
                    </a>
                    <li x-data="{ open: false }" class="relative">
                        <a href="#" class="hover:bg-white hover:text-gray-700 flex items-center p-2 rounded-lg group" @click="open = !open">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition duration-75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                            <span class="ms-3">Rekap</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 transition duration-75 transform absolute right-3 top-5 -translate-y-1/2" :class="{ 'rotate-180': open }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <ul x-show="open" @click.away="open = false" class="pl-5 mt-3">
                            <li>
                                <a href="<?= base_url('dashboard/rekap/transaksi') ?>" class="hover:bg-white flex items-center p-2 rounded-lg group bg-white text-gray-700 hover:text-gray-800 mt-2">
                                    <span class="ms-3">Rekap Transaksi</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('dashboard/rekap/jadwal') ?>" class="hover:bg-white flex items-center p-2 rounded-lg group bg-white text-gray-700 hover:text-gray-800 mt-2">
                                    <span class="ms-3">Rekap Jadwal</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <a href="<?= base_url('dashboard/transaksi') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/transaksi')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                            </svg>
                            Transaksi
                        </li>
                    </a>
                    <a href="<?= base_url('dashboard/laporan') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/laporan')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Laporan
                        </li>
                    </a>
                    <a href="<?= base_url('dashboard/paket') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/paket')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>
                            Paket
                        </li>
                    </a>
                    <a href="<?= base_url('dashboard/pelanggan') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/pelanggan')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            Pelanggan
                        </li>
                    </a>
                    <a href="<?= base_url('dashboard/user') ?>">
                        <li class="hover:bg-white hover:text-gray-800 transition-colors duration-300 p-3 my-2 <?= (current_url() === base_url('dashboard/user')) ? 'bg-gray-700' : ''; ?> rounded-lg flex justify-start items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            User
                        </li>
                    </a>
                <?php endif ?>
            </ul>
        </div>
    </div>
    <div class="min-h-screen flex justify-center items-center">
        <button @click="open = !open" class="mx-2 transition-all duration-300 hover:origin-center hover:rotate-180 hover:bg-sky=-500 bg-gray-800 text-white rounded-lg p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>
</div>