<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body onload="load_doc()">
    <div id="out"></div>
    <script>
        let arr;
        function load_doc(){
            out = document.getElementById("out");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function (){ 
                console.log(this.readyState + ", ", this.status);
                if(this.readyState==4 && this.status == 200){
                    arr = JSON.parse(this.responseText);
                }
                out.innerHTML = arr;
            }
            xhttp.open("GET","product_rest" ,true);
            xhttp.send();
        }
    </script>
</body>
</html>