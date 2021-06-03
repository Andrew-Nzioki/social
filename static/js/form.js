var num = 1;
function createFileField(){
    var x = document.createElement("INPUT");
    x.setAtrribute("type","file");
    x.setAtrribute("Name","file_"+num);

    document.getElementById("bucket_file").appendChild(x);
    num++;
};
