// 1. Hàm đếm lượt xem ngầm (Luôn luôn cần thiết)
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    set_post_views($post_id);
}
add_action( 'wp_head', 'track_post_views');

// 2. Hàm hiển thị thông số: Tự động chèn vào NGAY ĐẦU nội dung bài viết chi tiết
function show_reading_time_and_views( $content ) {
    // Chỉ hiển thị ở trang đọc chi tiết (Single Post), không ảnh hưởng trang chủ
    if ( is_single() && !is_admin() ) {
        global $post;
        
        // Tính thời gian đọc
        $word_count = str_word_count( strip_tags( $content ) );
        $reading_time = ceil( $word_count / 200 );
        if ($reading_time == 0) $reading_time = 1; // Tối thiểu 1 phút
        
        // Lấy số lượt xem
        $count_key = 'post_views_count';
        $views = get_post_meta($post->ID, $count_key, true);
        if($views == ''){ $views = 0; }
        
        // Tạo khung hiển thị đẹp mắt, nằm ngay dưới tiêu đề bài viết
        $info_html = '<div class="post-meta-info" style="font-size: 14px; color: #757575; font-weight: normal; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px dashed #ddd;">';
        $info_html .= '⏱️ Khoảng ' . $reading_time . ' phút đọc &nbsp;|&nbsp; 👀 ' . $views . ' lượt xem';
        $info_html .= '</div>';
        
        // Trả về thông số nằm TRƯỚC nội dung bài viết
        return $info_html . $content;
    }
    return $content;
}
add_filter( 'the_content', 'show_reading_time_and_views', 1 ); 
// Số 1 để nó ưu tiên hiện lên đầu tiên trước các nội dung khác