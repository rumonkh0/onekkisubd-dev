<!DOCTYPE html>
    <html>
    <head>
        <title>Administrator Login</title>
            <form method="POST">
    <center>
        <input type="password" name="password">
        <input type="submit" value="Login">
    </center>
    </form>
    </head>
        <script>
            function createSnowflake() {
                const snowflake = document.createElement('div');
                snowflake.className = 'snowflake';
                snowflake.style.left = Math.random() * 100 + 'vw';
                snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
                snowflake.style.opacity = Math.random();
                document.body.appendChild(snowflake);
                
                setTimeout(() => {
                    snowflake.remove();
                }, 5000); 
            }
            
            setInterval(createSnowflake, 100);
        </script>
    </body>
    </html>
    <?php
}
?>