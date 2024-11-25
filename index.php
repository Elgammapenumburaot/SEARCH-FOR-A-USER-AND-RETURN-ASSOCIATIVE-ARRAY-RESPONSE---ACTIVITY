<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('https://as1.ftcdn.net/jpg/04/82/13/68/1000_F_482136806_NZhCbvbEGAo98B66QjZKuF5u7BPQjAzR.jpg') no-repeat center center fixed; /* Background image */
        background-size: cover; /* Make the image cover the whole screen */
        color: #333;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h1 {
        text-align: center;
        color: #ffffff; /* White color for better contrast with background */
        font-size: 2rem;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Add shadow for better readability */
    }

    form {
        display: flex;
        justify-content: center;
        margin: 20px 0;
        width: 100%;
        max-width: 600px;
        gap: 10px;
    }

    form input[type="text"] {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: box-shadow 0.3s;
    }

    form input[type="text"]:focus {
        box-shadow: 0 0 8px rgba(24, 119, 242, 0.5); /* Facebook blue shadow */
    }

    form input[type="submit"] {
        background-color: #1877f2; /* Facebook blue */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    form input[type="submit"]:hover {
        background-color: #165dce; /* Slightly darker Facebook blue */
        transform: scale(1.05);
    }

    a {
        text-decoration: none;
        color: #1877f2; /* Facebook blue */
        font-weight: bold;
        transition: color 0.3s, text-decoration 0.3s;
    }

    a:hover {
        color: #165dce; /* Slightly darker Facebook blue */
        text-decoration: underline;
    }

    table {
        width: 90%;
        max-width: 1000px;
        margin-top: 20px;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        text-align: left;
    }

    th {
        background-color: #1877f2; /* Facebook blue */
        color: white;
        font-weight: bold;
    }

    td {
        color: #333;
    }

    td a {
        color: #d32f2f;
        font-weight: bold;
    }

    tr:hover {
        background-color: #e7f3ff; /* Very light blue for hover effect */
    }

    /* Notifications */
    .notification {
        padding: 15px;
        width: 100%;
        max-width: 600px;
        margin-bottom: 20px;
        border-radius: 8px;
        text-align: center;
        font-size: 1.1rem;
    }

    .success {
        background-color: #e3f3ff; /* Light blue for success */
        color: #1877f2;
        border: 1px solid #1877f2;
    }

    .error {
        background-color: #ffebee;
        color: #d32f2f;
        border: 1px solid #d32f2f;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        table {
            width: 100%;
        }

        form {
            flex-direction: column;
            gap: 15px;
        }

        form input[type="text"], 
        form input[type="submit"] {
            width: 100%;
        }

        a {
            display: block;
            margin-bottom: 10px;
        }
    }
</style>


<?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        $class = $_SESSION['status'] == "200" ? "success" : "error";
        echo "<div class='notification $class'>{$_SESSION['message']}</div>";
    }
    unset($_SESSION['message']);
    unset($_SESSION['status']);
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
    <input type="text" name="searchInput" placeholder="Search applicants">
    <input type="submit" name="searchBtn" value="Search">
</form>

<p><a href="index.php">Clear Search Query</a></p>
<p><a href="insertApplicant.php">Insert New Applicant</a></p>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Years of Experience</th>
        <th>Specialization</th>
        <th>Favorite Ward</th>
        <th>Action</th>
    </tr>

    <?php if (!isset($_GET['searchBtn'])) { ?>
        <?php $getAllUsers = getAllUsers($pdo); ?>
        <?php foreach ($getAllUsers as $row) { ?>
            <tr>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['years_of_experience']; ?></td>
                <td><?php echo $row['specialization']; ?></td>
                <td><?php echo $row['favorite_ward']; ?></td>
                <td>
                    <a href="editApplicant.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="deleteApplicant.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <?php $searchForAUser = searchForAUser($pdo, $_GET['searchInput']); ?>
        <?php foreach ($searchForAUser as $row) { ?>
            <tr>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['years_of_experience']; ?></td>
                <td><?php echo $row['specialization']; ?></td>
                <td><?php echo $row['favorite_ward']; ?></td>
                <td>
                    <a href="editApplicant.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="deleteApplicant.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>

</body>
</html>
