function check() {
    $.post("checkUsernameExists.php", {
        username: document.getElementById("txtUsername").value
    }, (result) => {
        const exists = JSON.parse(result).exists;
        document.getElementById("submit").disabled = exists;
        document.getElementById("submit").classList = ((exists == true) ? "btn_disable" : "btn");
    });
}