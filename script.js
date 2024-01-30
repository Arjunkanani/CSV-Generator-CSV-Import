function importCSV() {
    var form = document.getElementById('csvForm');
    var resultDiv = document.getElementById('result');

    var formData = new FormData(form);

    fetch('import.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data); // Log the response to the console
        if (data.count !== undefined) {
            resultDiv.innerHTML = 'Records imported: ' + data.count;
        } else {
            resultDiv.innerHTML = 'Invalid response from server.';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = 'Error: ' + error.message;
    });

}
