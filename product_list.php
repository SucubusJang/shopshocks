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
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function (){ 
                console.log(this.readyState + ", ", this.status);
                if(this.readyState==4 && this.status == 200){
                    arr = JSON.parse(this.responseText);
                    tabele_data(arr);
                }
                
            }
            xhttp.open("GET","product_rest.php" ,true);
            xhttp.send();
        }
        function tabele_data(arr){
            out = document.getElementById("out");
            text = "<table border='1'>";
            for(i=0;i<arr.length;i++){
                for(j=0;j<arr[i];j++){
                    text += "<td>"+arr[i][j]+"</td>";
                }
                text += "<tr>"+text+"</tr>";
            }
            text += "</table>";
            out.innerHTML = text;
        }
    </script>
</body>
</html>