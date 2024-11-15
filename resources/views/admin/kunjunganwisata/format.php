<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan Kunjungan Wisatawan</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            max-width: 1000px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .form-header h3 {
            font-size: 16px;
            color: darkgrey;
            margin: 0;
        }

        .form-header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .form-date {
            margin-right: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-save {
            background-color: rgba(236,111,55,255);
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .visitor-section {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .visitor-card {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .visitor-card strong {
            display: block;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #eee;
            font-weight: bold;
        }

        .table input.form-control {
            width: 100%;
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        tfoot td {
            font-weight: bold;
        }

        #add-row {
            width: 100%;
            font-weight: bold;
            margin-top: 10px;
            background-color: #3498db;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-row {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h3>Tambah Laporan Kunjungan</h3>
        <h2>Nama Wisata</h2>
        <div class="form-date">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" class="form-control">
        </div>
        <button type="submit" class="btn-save">Simpan Data</button>
    </div>

    <div class="visitor-section">
        <div class="visitor-card">
            <strong>Kunjungan Wisatawan Nusantara (WISNU)</strong>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kategori Usia</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Anak-anak</td>
                        <td><input type="number" class="form-control" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>Dewasa</td>
                        <td><input type="number" class="form-control" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>Lansia</td>
                        <td><input type="number" class="form-control" placeholder="0"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td><input type="number" class="form-control" placeholder="0" disabled></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="visitor-card">
            <strong>Kunjungan Wisatawan Mancanegara (WISMAN)</strong>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kategori Usia</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Anak-anak</td>
                        <td><input type="number" class="form-control" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>Dewasa</td>
                        <td><input type="number" class="form-control" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>Lansia</td>
                        <td><input type="number" class="form-control" placeholder="0"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td><input type="number" class="form-control" placeholder="0" disabled></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</body>
</html>
