<html>
 <head>
 <Title>Form Pesan dan Kesan</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Register here!</h1>
 <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Nama  <input type="text" name="nama" id="nama"/></br></br>
       Email <input type="text" name="email" id="email"/></br></br>
       Judul <input type="text" name="judul" id="judul"/></br></br>
       Pesan <input type="text" name="pesan" id="pesan"/></br></br>
       <input type="submit" name="submit" value="Submit" />
       <input type="submit" name="load_data" value="Load Data" />
 </form>
 <?php
    $host = "dicodingwebappservero.database.windows.net";
    $user = "orev";
    $pass = "Lima1092";
    $db = "dicodingdb";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $judul = $_POST['judul'];
            $pesan = $_POST['pesan'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO [dbo].[pesan] (nama, email, judul, pesan, date) 
                        VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $nama);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $judul);
			$stmt->bindValue(3, $pesan);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Terima kasih atas pesan dan kesan yang telah dikirimkan! :)</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM [dbo].[pesan]";
            $stmt = $conn->query($sql_select);
            $messages = $stmt->fetchAll(); 
            if(count($messages) > 0) {
                echo "<h2>Pesan dan Kesan yang telah masuk:</h2>";
                echo "<table>";
                echo "<tr><th>Nama</th>";
                echo "<th>Email</th>";
                echo "<th>Judul</th>";
                echo "<th>Pesan</th>";
                echo "<th>Date</th></tr>";
                foreach($messages as $pesankesan) {
                    echo "<tr><td>".$pesankesan['name']."</td>";
                    echo "<td>".$pesankesan['email']."</td>";
                    echo "<td>".$pesankesan['judul']."</td>";
                    echo "<td>".$pesankesan['pesan']."</td>";
                    echo "<td>".$pesankesan['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>