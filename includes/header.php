<!-- Page Header -->
<div class="container-fluid page-header mb-5 position-relative overlay-bottom">
  <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px;">
    <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">
    <p class="m-0 text-white">
<?php
if ($title == 'Search Results') {
  echo $langArray['search_page']['page_header'];
} else if ($title == 'Book') {
  echo $langArray['navbar']['book'];
} else if ($title == 'Books') {
  echo $langArray['navbar']['books'];
} else {
  $key = strtolower($title);
  if (isset($langArray['navbar'][$key])) {
    echo $langArray['navbar'][$key];
  } else {
    // إذا المفتاح غير موجود، عرض النص كما هو مع حماية HTML
    echo htmlspecialchars($title);
  }

  // أضف اسم التصنيف إن وُجد وكان العنوان "Categories"
  if ($title == 'Categories' && isset($cat_info['cat_name'])) {
    echo ' / ' . htmlspecialchars($cat_info['cat_name']);
  }
}
?>
</p>

    </div>
  </div>
</div>
