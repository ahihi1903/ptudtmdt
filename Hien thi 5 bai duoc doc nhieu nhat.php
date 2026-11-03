function most_viewed_posts_sidebar_shortcode() {
    // Cấu hình lấy top 5 bài viết xem nhiều nhất
    $most_viewed_posts = get_posts( array(
        'numberposts' => 5,
        'meta_key'    => 'post_views_count',
        'orderby'     => 'meta_value_num',
        'order'       => 'DESC',
    ) );
    
    // Bắt đầu gom giao diện vào biến $output
    $output = '';
    
    if ( !empty( $most_viewed_posts ) ) {
        $output .= '<div class="sidebar-most-viewed" style="padding: 15px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px;">';
        $output .= '<h2 style="font-size: 16px; color: #333; margin-top: 0; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid #ff9800; text-transform: uppercase; font-weight: bold;">🔥 Bài viết đọc nhiều</h2>';
        $output .= '<ul style="list-style: none; padding-left: 0; margin-bottom: 0;">';
        
        $stt = 1;
        foreach ( $most_viewed_posts as $p ) {
            $views = get_post_meta( $p->ID, 'post_views_count', true );
            if ( $views == '' ) { $views = 0; }
            
            $permalink = get_permalink( $p->ID );
            $title     = get_the_title( $p->ID );
            
            $output .= '<li style="padding: 8px 0; border-bottom: 1px dashed #eee; display: flex; flex-direction: column; gap: 4px;">';
            $output .= '<div style="display: flex; align-items: flex-start;">';
            // Số thứ tự nhỏ  
            $output .= '<span style="font-weight: bold; background: #eee; color: #555; min-width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; border-radius: 3px; margin-right: 8px; font-size: 11px; margin-top: 2px;">' . $stt . '</span>';
            // Tiêu đề bài viết
            $output .= '<a href="' . $permalink . '" style="color: #0073aa; font-weight: 600; text-decoration: none; font-size: 14px; line-height: 1.3;">' . $title . '</a>';
            $output .= '</div>';
            // Số lượt xem nằm gọn phía dưới tiêu đề
            $output .= '<span style="font-size: 11px; color: #999; padding-left: 28px;">👀 ' . $views . ' lượt đọc</span>';
            $output .= '</li>';
            
            $stt++;
        }
        
        $output .= '</ul>';
        $output .= '</div>';
    }
    
    return $output;
}
// Đăng ký shortcode với WordPress tên là [bai_viet_hot]
add_shortcode( 'bai_viet_hot', 'most_viewed_posts_sidebar_shortcode' );