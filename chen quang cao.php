<?php 
add_filter( 'the_content', 'insert_ads_into_paragraphs' );
function insert_ads_into_paragraphs( $content ) {
    // 1. THAY ĐOẠN QUẢNG CÁO CỦA BẠN VÀO ĐÂY (HTML tự làm hoặc code Google AdSense)
    $ad_code = '
    <div class="my-custom-ad" style="text-align:center; margin:20px 0;">
        <span style="font-size:10px; color:#aaa; display:block; text-align:center;">QUẢNG CÁO</span>
        <a href="https://baomoi.com/" target="_blank">
            <img src="http://localhost:8088/wordpress_demo/wp-content/uploads/2026/10/qc1.png" alt="Mua ngay" style="max-width:100%;" />
        </a>
    </div>';
    
    // Chỉ chèn vào trang chi tiết bài viết (is_single)
    if ( is_single() && ! is_admin() ) {
        return insert_after_paragraph_helper( $ad_code, 3, $content ); // Số 3 là vị trí sau đoạn văn thứ 3
    }
    return $content;
}

// Hàm bổ trợ để đếm đoạn văn và chèn code
function insert_after_paragraph_helper( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
    return implode( '', $paragraphs );
}
?>