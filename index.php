<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form to Calculate Land Area</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <style>
      #sidesContainer input[type="number"] {
        width: 5rem;
        text-align: center;
        margin-right: 1rem;
        margin-top: .5rem;
      }
      button[type="submit"]{
        margin-top: 1.1rem;
        margin-left: 10rem;
      }
      #result {
        margin-top: 2rem;
        padding: 1rem;
      }
    </style>
</head>
<body>
<h1>Calculate Irregular Land Area</h1>
<form id="landForm">
    <label for="sides">Enter the side lengths of the land (in meters):</label><br>
    <div id="sidesContainer">
        <input type="number" name="sides[]" placeholder="top | N" required>
        <input type="number" name="sides[]" placeholder="right | E" required>
        <input type="number" name="sides[]" placeholder="bottom | S" required>
        <input type="number" name="sides[]" placeholder="left | W" required>
    </div>
    <button type="submit">Calculate Area</button>
</form>
<div id="result"></div>
<script>
document.getElementById('landForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('result.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('result').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('result').innerHTML = `<p style="color:red;">Error: ${error.message}</p>`;
    });
});
</script>
</body>
</html>
