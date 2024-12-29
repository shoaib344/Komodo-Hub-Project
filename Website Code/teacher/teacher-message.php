<?php
include "../database-connection.php";

function getAllMessages($connect, $sender_id){
    $sql = "SELECT * FROM messages WHERE sender_id = ? OR receiver_id = ? ORDER BY date_time DESC";
    $stmt = $connect->prepare($sql);
    $stmt->execute([$sender_id, $sender_id]);

    if ($stmt->rowCount() >= 1) {
        $messages = $stmt->fetchAll();
        return $messages;
    } else {
        return [];
    }
}

function sendMessage($connect, $sender_id, $receiver_id, $message) {
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->execute([$sender_id, $receiver_id, $message]);
}

session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Teacher' || $_SESSION['role'] == 'Student' || $_SESSION['role'] == 'Admin') {
        // ... (your existing code)

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
            $receiver_id = $_POST['receiver_id'];
            $message = $_POST['message'];
            $sender_id = $_SESSION['user_id'];

            sendMessage($connect, $sender_id, $receiver_id, $message);
        }

        $messages = getAllMessages($connect, $_SESSION['user_id']);
?>
        <!DOCTYPE html>
        <!-- ... (your existing HTML) ... -->
        <?php
        if ($messages) {
        ?>
            <div class="accordion accordion-flush" id="accordionFlushExample">
        <?php
            foreach ($messages as $message) {
                // Your existing message display code
            }
        ?>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-info .w-450 m-5" role="alert">
                Empty!
            </div>
        <?php
        }
        ?>
        <!-- ... (your existing HTML) ... -->
        </html>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#receiver').select2({
                    ajax: {
                        url: 'get_users.php', // Make sure to create this file for user search
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (user) {
                                    return {
                                        text: user.username,
                                        id: user.user_id
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
        </script>
    </body>
    </html>

<?php
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>