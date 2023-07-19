<?php 

    ob_start();
    session_start();

    date_default_timezone_set('Asia/Jakarta');

    try {
		@$connection = new PDO( 'mysql:host=localhost; dbname=Crud', 'root', '' );
        @$connection -> exec( 'set names utf8' );
        @$connection -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $error ) {
        print "Koneksi Database : " . $error->getMessage() . "<br/>";
		die();
    }



    @$q_data = @$connection->prepare(" SELECT Nim, Nama, Jurusan FROM Siswa ");
    @$q_data->execute();
    @$d_data = @$q_data->fetch(PDO::FETCH_OBJ);


    if ( isset ( $_POST['BtnCrud'] ) ) {

        if ( @$d_data->Nim == TRUE ) {

            @$datas = [
                'Nama'      => @$_POST['Nama'],
                'Jurusan'   => @$_POST['Jurusan'],
                'Nim'       => @$_POST['Nim'],
            ];
            
            @$query_exc = @$connection->prepare(
                "
                    UPDATE Siswa SET Nama = :Nama, Jurusan = :Jurusan
                    WHERE Nim = :Nim
                "
            )->execute(@$datas);

            if ( @$query_exc ) {
                @$alert = 
                    "
                        <div class='alert alert-success' role='alert'>
                            Berhasil Ubah Data !
                        </div>
                    ";
                
                @$_SESSION['notif'] = @$alert;
                
                echo "
                    <script>
                        window.location.replace('./');
                    </script>
                ";
            } else {
                @$alert = 
                    "
                        <div class='alert alert-danger' role='alert'>
                            Tidak Berhasil Ubah Data !
                        </div>
                    ";

                @$_SESSION['notif'] = @$alert;

                echo "
                    <script>
                        window.location.replace('./');
                    </script>
                ";
            }
            
        } else {

            @$datas = [
                'Nim'       => @$_POST['Nim'],
                'Nama'      => @$_POST['Nama'],
                'Jurusan'   => @$_POST['Jurusan'],
            ];
            
            @$query_exc = @$connection->prepare(
                "
                    INSERT INTO Siswa (Nim, Nama, Jurusan)
                    VALUES (:Nim, :Nama, :Jurusan)
                "
            )->execute(@$datas);

            if ( @$query_exc ) {
                @$alert = 
                    "
                        <div class='alert alert-primary' role='alert'>
                            Berhasil Simpan Data !
                        </div>
                    ";

                @$_SESSION['notif'] = @$alert;

                echo "
                    <script>
                        window.location.replace('./');
                    </script>
                ";
            } else {
                @$alert = 
                    "
                        <div class='alert alert-danger' role='alert'>
                            Tidak Berhasil Simpan Data !
                        </div>
                    ";

                @$_SESSION['notif'] = @$alert;
                
                echo "
                    <script>
                        window.location.replace('./');
                    </script>
                ";
            }

        }

    } elseif ( isset ( $_POST['BtnHapus'] ) ) {

        @$datas = [
            'Nim'       => @$_POST['Nim'],
        ];
        
        @$query_exc = @$connection->prepare(
            "
                DELETE FROM Siswa
                WHERE Nim = :Nim
            "
        )->execute(@$datas);

        if ( @$query_exc ) {
            @$alert = 
                "
                    <div class='alert alert-danger' role='alert'>
                        Berhasil Hapus Data !
                    </div>
                ";
            
            @$_SESSION['notif'] = @$alert;
            
            echo "
                <script>
                    window.location.replace('./');
                </script>
            ";
        } else {
            @$alert = 
                "
                    <div class='alert alert-warning' role='alert'>
                        Tidak Berhasil Hapus Data !
                    </div>
                ";

            @$_SESSION['notif'] = @$alert;

            echo "
                <script>
                    window.location.replace('./');
                </script>
            ";
        }

    }
    

?>



<?php if ( @$connection == TRUE ) { ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>
        Aplikasi Crud 1 File
    </title>
</head>

<body>
    <div class="container mt-lg-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">
                    Aplikasi Crud 1 File
                </h1>
                <hr>

                <?php
                    if ( @$_SESSION['notif'] ) {
                        echo @$_SESSION['notif'];
                    }    
                ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>
                                    NIM Siswa
                                    <small class="form-text text-danger">
                                        NIM Siswa Tidak Boleh Sama
                                    </small>
                                </label>
                                <input type="number" class="form-control" name="Nim" autocomplete="off"
                                    value="<?= @$d_data->Nim; ?>" placeholder="NIM Siswa" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>
                                    Nama Siswa
                                    <small class="form-text text-danger">
                                        Nama Siswa Tidak Boleh Sama
                                    </small>
                                </label>
                                <input type="text" class="form-control" name="Nama" autocomplete="off"
                                    value="<?= @$d_data->Nama; ?>" placeholder="Nama Siswa" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>
                                    Jurusan Siswa
                                    <small class="form-text text-danger">
                                        Jurusan Siswa Tidak Boleh Sama
                                    </small>
                                </label>
                                <select name="Jurusan" class="form-control" required>
                                    <?php if ( @$d_data->Jurusan ) { ?>
                                    <option value="<?= @$d_data->Jurusan; ?>" selected>
                                        <?= @$d_data->Jurusan; ?>
                                    </option>
                                    <option value="" disabled>--- ##### ---</option>
                                    <?php } else { ?>
                                    <option value="" disabled selected>--- Pilih Jurusan ---</option>
                                    <?php } ?>
                                    <option value="Sistem Informasi">
                                        Sistem Informasi
                                    </option>
                                    <option value="Sistem Komputer">
                                        Sistem Komputer
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal-Crud-Data">
                        <?php 
                            if ( @$d_data->Nim ) {
                                echo "Ubah";
                            } else {
                                echo "Simpan";
                            }
                        ?>
                    </button>
                    <div class="modal fade" id="Modal-Crud-Data" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Informasi
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <?php 
                                        if ( @$d_data->Nim ) {
                                            echo "Apakah Anda Yakin Untuk Ubah Data Ini ?";
                                        } else {
                                            echo "Apakah Anda Yakin Untuk Simpan Data Ini ?";
                                        }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        Tutup
                                    </button>
                                    <button type="submit" class="btn btn-primary" name="BtnCrud">
                                        <?php 
                                            if ( @$d_data->Nim ) {
                                                echo "Ubah";
                                            } else {
                                                echo "Simpan";
                                            }
                                        ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ( @$d_data->Nim ) { ?>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal-Delete-Data">
                        Hapus
                    </button>
                    <div class="modal fade" id="Modal-Delete-Data" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Informasi
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    Apakah Anda Yakin Untuk Hapus Data Ini ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        Tutup
                                    </button>
                                    <button type="submit" class="btn btn-danger" name="BtnHapus">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>

<?php } ?>