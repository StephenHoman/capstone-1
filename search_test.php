<?php
require_once "dBCred.PHP";
?>


<!-- Search -->
<?php
        $searchErr = '';
        $itemResultCount = 0;
        $userResultCount = 0;
        if(isset($_GET['save'])){
            if(!empty($_GET['search'])){
                $searchTerm = "%".$_GET['search']."%";
                $sqlItem = "select i.item_name, i.item_description, i.date_posted, t.tag_name from items i left join item_tags it on it.item_id = i.item_id left join tags t on t.tag_id = it.tag_id where i.item_name like ? or i.item_description like ? or t.tag_name like ?";
                if($stmtItem = mysqli_prepare($conn, $sqlItem)){
                    mysqli_stmt_bind_param($stmtItem, 'sss', $search1, $search2, $search3);
                    $search1 = $searchTerm;
                    $search2 = $searchTerm;
                    $search3 = $searchTerm;
                }
                mysqli_stmt_execute($stmtItem);
                mysqli_stmt_bind_result($stmtItem, $item_name, $item_description, $date_posted, $tag_name);
                mysqli_stmt_store_result($stmtItem);
                $itemResultCount = mysqli_stmt_num_rows($stmtItem);

                $sqlUser = "SELECT user_username FROM login WHERE user_username LIKE ?";
                if($stmtUser = mysqli_prepare($conn, $sqlUser)){
                    mysqli_stmt_bind_param($stmtUser, 's', $searchUser);
                    $searchUser = $searchTerm;
                }
                mysqli_stmt_execute($stmtUser);
                mysqli_stmt_bind_result($stmtUser, $user_username);
                mysqli_stmt_store_result($stmtUser);
                $userResultCount = mysqli_stmt_num_rows($stmtUser);
            }
            else{
                $searchErr = "Error!";
            }
        }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- JS Scripts -->
    <script src="script.js"></script>

    <script>
        // fixes sizing issue when page is scaled to under 768px, the profile image would 
        // no longer flex correctly. This bit quickly fixes it. 
        document.addEventListener("DOMContentLoaded", function() {
        size()
          });
          document.addEventListener("resize", function() {
        size();
          });
    </script>

    <title>Dashboard</title>
</head>

<body>

    <div>

        <form id="searchform" method="GET">
            <input type="text" class="form-control" name="search" placeholder="search here">
            <button type="submit" name="save" class="btn btn-success btn-sm">Submit</button>
        </form>

    </div>

    </br>

    <div>
        <table width=100%>
            <tr>
                <td width=75%>Item Search Results: <?php echo $itemResultCount; ?></td>
                <td width=25%>User Search Results: <?php echo $userResultCount; ?></td>
            </tr>
            <tr>
                <td width=75%>
                    <table>
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Description</th>
                                <th>Date Posted</th>
                                <th>Tags</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while (mysqli_stmt_fetch($stmtItem)) { 
                                    echo "<tr>";
                                        echo "<td>" . $item_name . "</td>";
                                        echo "<td>" . $item_description . "</td>";
                                        echo "<td>" . $date_posted . "</td>";
                                        echo "<td>" . $tag_name . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </td>
                <td width=25%>
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while (mysqli_stmt_fetch($stmtUser)) { 
                                    echo "<tr>";
                                    echo "<td>" . $user_username . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</body>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>
</body>

</html>