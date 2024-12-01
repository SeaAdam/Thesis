<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class="navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <!-- Profile icon or user name can go here -->
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out pull-right"></i>
                            Log Out</a>
                    </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green"><?php echo $unread_count; ?></span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        <?php
                        foreach ($notificationsAdmin as $notification) {
                            $statusClass = $notification['status'] == 0 ? 'unread' : 'read';
                            $transactionNo = htmlspecialchars($notification['transaction_no']);
                            $message = htmlspecialchars($notification['message']);
                            $createdAt = htmlspecialchars($notification['created_at']);

                            echo '<li class="nav-item">';
                            echo '<a class="dropdown-item ' . $statusClass . '" href="javascript:;" onclick="markAsRead(\'' . $transactionNo . '\')">';
                            echo '<span class="message">' . $message . '</span>';
                            echo '<span class="time">' . $createdAt . '</span>';
                            echo '</a>';
                            echo '</li>';
                        }
                        ?>


                        <li class="nav-item">
                            <a class="dropdown-item" href="javascript:;" onclick="markAllAsRead()">
                                <i class="fa fa-check"></i> Mark All as Read
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->