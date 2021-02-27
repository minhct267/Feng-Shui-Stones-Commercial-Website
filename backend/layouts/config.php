<?php
    switch ($_SERVER['SCRIPT_NAME']) {
        case "/web_thuongmai/backend/pages/trangchu.php":
            $CURRENT_PAGE = "backend.page_function.index";
            $PAGE_TITLE = "Trang chủ";
            break;
          case "/web_thuongmai/backend/pages/dashboard.php":
            $CURRENT_PAGE = "backend.page_function.dashboard";
            $PAGE_TITLE = "Bảng tin";
            break;
          case "/web_thuongmai/backend/pages/contact.php":
            $CURRENT_PAGE = "backend.page_function.contact";
            $PAGE_TITLE = "Liên hệ";
            break;
        
            // Tên trang và Tiêu đề mặc định
          default:
            $CURRENT_PAGE = "backend.index";
            $PAGE_TITLE = "Vườn đá của nấm";
    }
?>