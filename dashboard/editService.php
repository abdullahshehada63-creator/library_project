<?php
ob_start();
include "headerPart.php";

// استرجاع service_id من الرابط
$service_id = intval($_GET['service_id']);

// جلب بيانات الخدمة من قاعدة البيانات
$serviceData = mysqli_query($conn, "SELECT `service_name_en`, `service_name_ar`, `show_on_index` FROM `service` WHERE `service_id`=$service_id");
$serviceData = mysqli_fetch_assoc($serviceData);

// تحديد القيم الافتراضية عند تحميل الصفحة لأول مرة
if (!isset($_POST['save'])) {
    $_POST['service_name_en'] = $serviceData['service_name_en'];
    $_POST['service_name_ar'] = $serviceData['service_name_ar'];
    $_POST['show_on_index'] = $serviceData['show_on_index'];
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading text-center" style="font-size: 20px; font-weight: bolder;">Edit Service</div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 text-center">
                    <br /><br />
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="text" name="service_name_en" value="<?= htmlspecialchars($_POST['service_name_en'] ?? '') ?>" class="form-control" placeholder="Enter Service Name (English)" /><br />
                                <input type="text" name="service_name_ar" value="<?= htmlspecialchars($_POST['service_name_ar'] ?? '') ?>" class="form-control" placeholder="أدخل اسم الخدمة (عربي)" dir="rtl" /><br />
                                
                                <input type="file" name="img" class="form-control" /><br />
                                <img src="getMajorServiceImg.php?img_id=<?= $service_id ?>" width="100%" /><br /><br />

                                <label>
                                    <input type="checkbox" name="show_on_index" value="1" <?= (isset($_POST['show_on_index']) && $_POST['show_on_index'] == 1) ? 'checked' : '' ?>>
                                    Show service on home page
                                </label><br /><br />

                                <input type="submit" name="save" value="Save" class="btn btn-primary" />
                            </form>

                            <?php
                            if (isset($_POST['save'])) {
                                // تحقق من عدم ترك الحقول فارغة
                                if (!empty($_POST['service_name_en']) && !empty($_POST['service_name_ar'])) {
                                    $serviceNameEn = mysqli_real_escape_string($conn, $_POST['service_name_en']);
                                    $serviceNameAr = mysqli_real_escape_string($conn, $_POST['service_name_ar']);
                                    $showOnIndex = isset($_POST['show_on_index']) ? 1 : 0;
                                    $img = "";

                                    if (!empty($_FILES['img']['tmp_name'])) {
                                        $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
                                    }

                                    if (empty($img)) {
                                        // تحديث بدون صورة
                                        mysqli_query($conn, "UPDATE `service` SET 
                                            `service_name_en`='$serviceNameEn',
                                            `service_name_ar`='$serviceNameAr',
                                            `show_on_index`='$showOnIndex'
                                            WHERE `service_id`=$service_id
                                        ");
                                    } else {
                                        // تحديث مع صورة
                                        mysqli_query($conn, "UPDATE `service` SET 
                                            `service_name_en`='$serviceNameEn',
                                            `service_name_ar`='$serviceNameAr',
                                            `img`='$img',
                                            `show_on_index`='$showOnIndex'
                                            WHERE `service_id`=$service_id
                                        ");
                                    }

                                    // إعادة التوجيه بعد الحفظ
                                    header("Location: services.php");
                                    exit;
                                } else {
                                    echo "<div class='alert alert-danger'>Please fill in both English and Arabic names.</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush();
include "footerPart.php";
?>
