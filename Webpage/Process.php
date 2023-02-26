<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <link rel="stylesheet" href="./mod.css">
        <link rel="icon" href="./Picture/Logo.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>The leaf you have</title>
    </head>
    <body>
        <!-- TOP NAVIGATOR-->
        <div>
            <nav class="topnav">
                <a href="./index.php"><img src="./Picture/Logo.png" width="30" height="30">AI Image Processing</a>
                <div class="topnav-right">
                    <a class="active" href="./index.php"><i class="fa fa-fw fa-home"></i>Home</a>
                    <a href="./About.php"><i class="fa fa-fw fa-user"></i>About</a>
                </div>
            </nav>
        </div>
        <!-- END TOP NAVIGATOR-->
        <!-- SEARCH-->
        <form class="was-validated" method="post" enctype="multipart/form-data" align="center">
        <div class="container">
            <h1>ลองทายดู ว่าใบที่คุณมีคือใบอะไร?</h1>
            <div class="banner">
                <div class="card-body">
                <class="card-title"><img src="./Picture/WWW.png" width="600"  class="d-inline-block align-top" alt=""><br>
                <p class="card-text">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" required>
                        <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                    </div>
                </p>
                <button type="submit" class="btn btn-success" type="submit" value="Image-Test" name="submit" onclick="Show()">Process</button>
                </div>
            </div>
            <p>กรุณาอัพโหลดไฟล์ที่มีสกุลไฟล์เป็น .jpg หรือ .jpeg หรือ .png</p>
        </div>
        </form>
        <!-- END SEARCH-->
        <!-- PROCESS -->
        <?php
        error_reporting(error_reporting() & ~E_NOTICE);
        $target_dir = "Image-Upload/";
        $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if (isset($_POST["submit"])) {
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JEPG") {
            echo "<h4 align=\"center\"><span style=\"background-color:#FFFF00;\">&nbsp;&nbsp;&nbsp;กรุณาเลือกไฟล์ที่นามสกุลเป็น JPG,PNG,JPEG&nbsp;&nbsp;&nbsp;</span></h4>";
            $uploadOk = 0;
        } else {
            @copy($_FILES["fileToUpload"]["tmp_name"], $target_dir."upload.png");

            $ImageFilter = "java -cp weka.jar;imageFilters.jar;lire.jar weka.filters.unsupervised.instance.imagefilter.SimpleColorHistogramFilter -i Test-Upload.arff -D Image-Upload -o Image-Upload\Data.arff";
            exec($ImageFilter);
            $RemoveString = "java -cp weka.jar weka.filters.unsupervised.attribute.RemoveType -T string -i Image-Upload\Data.arff -o Image-Upload\RemoveString.arff";
            exec($RemoveString);
            $Prediction = "java -cp weka.jar weka.classifiers.trees.RandomForest -T Image-Upload\RemoveString.arff -l Model\RandomForestModel.model -p 0";
            exec($Prediction, $output);
            echo $output[0];
        }
        }

        preg_match('#[[:alpha:]]+#', $output[5], $output);

        if ($output[0] != "") {
        if ($output[0] == "P") {
            $Imgname = "Webpage/Picture/Pepper.png";
            $Name = "Pepperl";
            $info  = "Pepper พริกไทย อาจเรียกว่า pepper corn เป็นส่วนผลที่ใช้เป็นเครื่องเทศซึ่งใช้เป็นวัตถุปรุงแต่งกลิ่นรสอาหารจากธรรมชาติ พริกไทย มีชื่อพื้นบ้านว่า พริกน้อย ( ภาคเหนือ )";
        } else if ($output[0] == "E") {
            $Imgname = "Webpage/Picture/Potato.png";
            $Name = "Potato";
            $info  = "Potato มันฝรั่ง หรือ Irish potato) เป็นพืชหัว (tuber crop) มีชื่อวิทยาศาสตร์ว่า โซลานัมทูเบอโรซุม (Solanum tuberosum) อยู่ในตระกูล โซลานาซี (Solanaceae) มันฝรั่งจัดเป็นพวกพืชล้มลุก เป็นพืชที่มีความสำคัญทางเศรษฐกิจ นำมาประกอบเป็นอาหารได้หลายชนิด และยังเป็นวัตถุดิบเพื่อการแปรรูปเป็นผลิตภัณฑ์ได้อีกหลายชนิด เช่น มันฝรั่งทอดกรอบแบบแผ่น (potato chip) เฟรนซ์ฟรายด์ (french fried)
            สตาร์ชมันฝรั่ง (potato starch)";
        } else if ($output[0] == "T") {
            $Imgname = "Webpage/Picture/Tomato.png";
            $Name = "Tomato";
            $info  = "Tomato มะเขือเทศ (ชื่อวิทยาศาสตร์: Lycopersicon esculentum Mill.) เป็นพืชชนิดหนึ่งในตระกูลผลมีเนื้อหลายเมล็ด อุดมไปด้วยคุณค่าทางอาหาร มะเขือเทศขนาดปานกลางจะมีปริมาณวิตามินซีครึ่งหนึ่งของส้มโอทั้งผล มะเขือเทศผลหนึ่งจะมีวิตามินเอราว 1 ใน 3 ของวิตามินเอที่ร่างกายต้องการในหนึ่งวัน นอกจากนี้มะเขือเทศยังมีโพแทสเซียม ฟอสฟอรัส แมกนีเซียม และแร่ธาตุอื่น ๆ อีกหลายชนิด";
        } 

        ?>

            <div class="container">
            <div class="banner">
                <h3>ผลการทำนาย</h3>
                <h5>โดยใช้ Filter : RGB Color Histogram</h5>
                <div class="row" style="margin:auto">
                <div class="col">
                    <div class="column">
                    <center>
                        <p style="font-size: 27px;">รูปที่คุณอัพโหลด</p>
                        <div class="circle">
                        <img src="Image-Upload/upload.png" alt="Image" class="image">
                        </div>
                        <p style="font-size: 25px;">รูปภาพที่คุณอัพโหลดเข้ามาอาจจะเป็น</p>
                        <p style="font-size: 25px;"><?= $Name ?></p>
                    </center>
                    </div>
                </div>
                <div class="col">
                <div class="column">
                    <center>
                        <p style="font-size: 27px;">ผลการทำนายภาพ</p>
                        <div class="circle">
                        <img src="../<?= $Imgname ?>" alt="Image" class="image">
                        </div>
                        <p style="font-size: 25px;"><?= $Name ?></p>
                        <p style="font-size: 25px;"><?= $info ?></p>
                    </center>
                    </div>
                </div>
                </div>
                </div>
            </div> 
        <?php } ?>

        <script>
            function Show() {
                var x = document.getElementById("showhide");
                x.style.display = "block";
                }
            $(".custom-file-input").on("change", function() {
            var fileName = $(".custom-file-input").val().split("\\").pop();
            $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>
        <!-- Footer -->
        <footer>
        <div class="footer"> © 2023 Copyright:
        <a href="https://ced.kmutnb.ac.th/"> TCT Computer Education KMUTNB</a>
        </div>
        </footer>
        <!-- END Footer -->
    </body>
</html>