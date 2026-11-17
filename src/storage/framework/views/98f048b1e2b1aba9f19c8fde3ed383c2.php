<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Ujian - <?php echo e($pendaftaran->nomor_pendaftaran); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #193128;
            padding: 20px;
        }

        .card {
            border: 2px solid #0d4a36;
            border-radius: 8px;
            overflow: hidden;
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            background: #0d4a36;
            color: white;
            padding: 14px 20px;
            border-bottom: 4px solid #d8ae45;
        }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-logo { width: 60px; vertical-align: middle; }
        .header-logo img { width: 55px; height: 55px; object-fit: contain; }
        .header-text { vertical-align: middle; padding-left: 12px; }
        .header-title {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: .5px;
        }
        .header-subtitle {
            font-size: 10px;
            color: #e9d28b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .header-desc {
            font-size: 9px;
            color: #d6e3d0;
            margin-top: 3px;
        }

        .card-title {
            text-align: center;
            padding: 12px;
            background: #f4f8ee;
            border-bottom: 1px solid #dce6d3;
        }
        .card-title h2 {
            font-size: 14px;
            color: #0d4a36;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .card-title p {
            font-size: 10px;
            color: #617064;
            margin-top: 2px;
        }

        .body { padding: 16px 20px; }

        .nomor-box {
            background: #f4f8ee;
            border: 1px dashed #5d9f3f;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            margin-bottom: 14px;
        }
        .nomor-label {
            font-size: 9px;
            color: #699944;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .nomor-value {
            font-family: DejaVu Sans Mono, monospace;
            font-size: 18px;
            font-weight: bold;
            color: #0d4a36;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 11px;
        }
        .info-table .label { width: 35%; color: #617064; }
        .info-table .colon { width: 3%; text-align: center; }
        .info-table .value { font-weight: bold; color: #244535; }

        .jadwal-box {
            background: #fff8dd;
            border: 1px solid #d8ae45;
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 14px;
        }
        .jadwal-title {
            font-size: 10px;
            color: #805500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .jadwal-table { width: 100%; border-collapse: collapse; }
        .jadwal-table td { padding: 3px 0; font-size: 11px; }
        .jadwal-table .label { width: 40%; color: #805500; }
        .jadwal-table .colon { width: 3%; text-align: center; color: #805500; }
        .jadwal-table .value { font-weight: bold; color: #76530d; }

        .catatan {
            background: #fff0ea;
            border: 1px solid #f2c1ae;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 10px;
            line-height: 1.6;
            color: #963d21;
            margin-bottom: 14px;
        }
        .catatan strong { color: #7a2f19; }

        .footer {
            border-top: 1px solid #dce6d3;
            padding-top: 10px;
            font-size: 9px;
            color: #617064;
            text-align: center;
        }
        .footer-tanggal { margin-bottom: 4px; }

        .ttd-area {
            width: 100%;
            margin-top: 16px;
            margin-bottom: 10px;
        }
        .ttd-table { width: 100%; border-collapse: collapse; }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
            color: #244535;
            padding-top: 8px;
        }
        .ttd-space { height: 45px; }
        .ttd-name {
            border-top: 1px solid #244535;
            padding-top: 3px;
            font-weight: bold;
            display: inline-block;
            min-width: 130px;
        }
        .ttd-sub {
            font-size: 9px;
            color: #617064;
            margin-top: 2px;
        }
    </style>
</head>
<body>

<div class="card">

    
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <?php if($info['logo_base64']): ?>
                        <img src="<?php echo e($info['logo_base64']); ?>" alt="Logo">
                    <?php endif; ?>
                </td>
                <td class="header-text">
                    <div class="header-subtitle"><?php echo e($info['yayasan_nama']); ?></div>
                    <div class="header-title"><?php echo e(strtoupper($info['header_name'])); ?></div>
                    <div class="header-desc">
                        Penerimaan Santri Baru — Tahun Ajaran <?php echo e($info['yayasan_tahun_ajaran']); ?>

                    </div>
                </td>
            </tr>
        </table>
    </div>

    
    <div class="card-title">
        <h2>KARTU PESERTA UJIAN</h2>
        <p>Simpan kartu ini dan bawa saat mengikuti ujian seleksi</p>
    </div>

    
    <div class="body">

        
        <div class="nomor-box">
            <div class="nomor-label">Nomor Pendaftaran</div>
            <div class="nomor-value"><?php echo e($pendaftaran->nomor_pendaftaran); ?></div>
        </div>

        
        <table class="info-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->nama_lengkap); ?></td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->nisn); ?></td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->jenis_kelamin); ?></td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->tempat_lahir); ?>, <?php echo e($pendaftaran->tanggal_lahir?->isoFormat('D MMMM Y')); ?></td>
            </tr>
            <tr>
                <td class="label">Asal Sekolah</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->asal_sekolah); ?></td>
            </tr>
            <tr>
                <td class="label">Jenjang Pendaftaran</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->jenjang->nama); ?></td>
            </tr>
            <tr>
                <td class="label">Gelombang</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->gelombang->nama); ?></td>
            </tr>
            <tr>
                <td class="label">No. WhatsApp</td>
                <td class="colon">:</td>
                <td class="value"><?php echo e($pendaftaran->no_whatsapp); ?></td>
            </tr>
        </table>

        
        <div class="jadwal-box">
            <div class="jadwal-title">📅 Jadwal Ujian</div>
            <table class="jadwal-table">
                <tr>
                    <td class="label">Tanggal Ujian</td>
                    <td class="colon">:</td>
                    <td class="value">
                        <?php if($pendaftaran->tanggal_ujian): ?>
                            <?php echo e($pendaftaran->tanggal_ujian->isoFormat('dddd, D MMMM Y')); ?>

                        <?php else: ?>
                            <em>Belum dijadwalkan</em>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">Status Ujian</td>
                    <td class="colon">:</td>
                    <td class="value"><?php echo e($pendaftaran->status_ujian); ?></td>
                </tr>
            </table>
        </div>

        
        <div class="catatan">
            <strong>Catatan Penting:</strong>
            <ul style="margin-left: 14px; margin-top: 3px;">
                <li>Kartu ini wajib dibawa saat mengikuti ujian seleksi.</li>
                <li>Hadir 30 menit sebelum ujian dimulai.</li>
                <li>Membawa alat tulis sendiri (pensil 2B, pena hitam, penghapus).</li>
                <li>Berpakaian rapi dan sopan.</li>
                <li>Kartu ini tidak berlaku jika data terbukti tidak valid.</li>
            </ul>
        </div>

        
        <div class="ttd-area">
            <table class="ttd-table">
                <tr>
                    <td>
                        Peserta,
                        <div class="ttd-space"></div>
                        <div class="ttd-name"><?php echo e($pendaftaran->nama_lengkap); ?></div>
                    </td>
                    <td>
                        Panitia SPMB,
                        <div class="ttd-space"></div>
                        <div class="ttd-name"><?php echo e($info['yayasan_kepala'] ?: '( .................... )'); ?></div>
                        <?php if($info['yayasan_nip_kepala']): ?>
                            <div class="ttd-sub">NIP/NIY: <?php echo e($info['yayasan_nip_kepala']); ?></div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        
        <div class="footer">
            <div class="footer-tanggal">
                Dicetak pada: <?php echo e($tanggalCetak); ?>

            </div>
            <div>
                <?php echo e($info['yayasan_nama']); ?>

                <?php if($info['yayasan_alamat']): ?>
                    · <?php echo e($info['yayasan_alamat']); ?>

                    <?php if($info['yayasan_kota']): ?>, <?php echo e($info['yayasan_kota']); ?> <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if($info['yayasan_telp'] || $info['yayasan_email'] || $info['yayasan_website']): ?>
                <div style="margin-top: 3px;">
                    <?php if($info['yayasan_telp']): ?> Telp/WA: <?php echo e($info['yayasan_telp']); ?> <?php endif; ?>
                    <?php if($info['yayasan_email']): ?> · <?php echo e($info['yayasan_email']); ?> <?php endif; ?>
                    <?php if($info['yayasan_website']): ?> · <?php echo e($info['yayasan_website']); ?> <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html><?php /**PATH /var/www/html/resources/views/student/kartu-pdf.blade.php ENDPATH**/ ?>