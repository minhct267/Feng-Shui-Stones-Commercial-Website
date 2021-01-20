<?php
    switch ($_SERVER['SCRIPT_NAME']) {
        case "/web_thuongmai/frontend/pages/trangchu.php":
            $CURRENT_PAGE = "frontend.page_function.index";
            $PAGE_TITLE = "Trang chủ";
            break;
          case "/web_thuongmai/frontend/pages/dashboard.php":
            $CURRENT_PAGE = "frontend.page_function.dashboard";
            $PAGE_TITLE = "Bảng tin";
            break;
          case "/web_thuongmai/frontend/pages/contact.php":
            $CURRENT_PAGE = "frontend.page_function.contact";
            $PAGE_TITLE = "Liên hệ";
            break;
        
            // Tên trang và Tiêu đề mặc định
          default:
            $CURRENT_PAGE = "frontend.index";
            $PAGE_TITLE = "Vườn đá của nấm";
    }
?>