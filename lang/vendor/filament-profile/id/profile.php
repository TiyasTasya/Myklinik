<?php

return [
    'menu' => [
        'label' => 'Profil Saya',
    ],

    'widget' => [
        'profile' => [
            'label' => 'Profil Saya',
        ],
    ],

    'fields' => [
        'current_password' => 'Password Saat Ini',
        'password' => 'Password Baru',
        'password_confirmation' => 'Konfirmasi Password Baru',
    ],

    'sections' => [
        'profile' => [
            'title' => 'Informasi Profil',
            'description' => 'Perbarui informasi akun profil dan alamat email Anda.',
            'actions' => [
                'save' => 'Simpan Perubahan',
            ],
        ],
        'password' => [
            'title' => 'Perbarui Password',
            'description' => 'Pastikan akun Anda menggunakan password yang kuat dan aman.',
            'actions' => [
                'save' => 'Simpan Password',
            ],
        ],
        'sessions' => [
            'title' => 'Sesi Browser Aktif',
            'description' => 'Kelola dan keluar dari sesi aktif Anda di browser atau perangkat lain.',
            'intro' => 'Jika diperlukan, Anda dapat keluar dari semua sesi browser Anda di seluruh perangkat lain. Jika Anda merasa akun Anda tidak aman, segera ubah password Anda.',
            'empty' => 'Tidak ada sesi browser lain yang ditemukan.',
            'unknown' => 'Tidak Diketahui',
            'this_device' => 'Perangkat Ini',
            'last_active' => 'Terakhir aktif',
            'confirm_logout_session' => 'Apakah Anda yakin ingin keluar dari sesi browser ini?',
            'columns' => [
                'device' => 'Perangkat',
                'ip_address' => 'Alamat IP',
                'last_active' => 'Terakhir Aktif',
                'actions' => 'Aksi',
            ],
            'actions' => [
                'logout' => 'Keluar',
                'logout_others' => 'Keluar dari Sesi Lain',
            ],
            'modal' => [
                'heading' => 'Keluar dari Sesi Browser Lain',
                'description' => 'Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin keluar dari semua sesi browser di perangkat lain.',
            ],
        ],
        'delete' => [
            'title' => 'Hapus Akun',
            'description' => 'Hapus akun Anda secara permanen.',
            'warning' => [
                'heading' => 'Tindakan ini permanen',
                'description' => 'Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen.',
            ],
            'actions' => [
                'delete' => 'Hapus Akun',
            ],
            'modal' => [
                'heading' => 'Hapus Akun',
                'description' => 'Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.',
            ],
        ],
    ],

    'notifications' => [
        'profile_updated' => 'Profil berhasil diperbarui.',
        'password_updated' => 'Password berhasil diperbarui.',
        'other_browser_sessions_logged_out' => 'Berhasil keluar dari sesi browser lain.',
        'browser_session_logged_out' => 'Berhasil keluar dari sesi browser.',
    ],
];

