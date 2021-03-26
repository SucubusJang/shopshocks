<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
  
</style>
<body>
    <div>
        <div style="width: 500px; margin: 0 auto;border: 2px solid red; padding: 20px">
        <h3>ShopShock Member Register</h3>
            <form action="rest.php" method="post">
                <table class="table" style="margin: 0 auto">
                    <tbody>
                        <tr>
                            <td>
                                <label for="">Name:</label>
                            </td>
                            <td><input type="text" name="name" id="name"></td>
                        </tr>
                        <tr>
                            <td><label for="">NickName:</label></td>
                            <td><input type="text" name="nickname" id="nickname"></td>
                        </tr>
                        <tr>
                            <td><label for="">Password:</label></td>
                            <td><input type="text" name="password" id="password"></td>
                        </tr>
                        <tr>
                            <td><label for="">Confirm Password:</label></td>
                            <td>
                                <input type="text" name="con_pass" id="con_pass">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Submit"> <input type="reset" value="Reset"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>

</html>