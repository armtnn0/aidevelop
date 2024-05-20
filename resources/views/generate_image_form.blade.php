<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Generation Form</title>
</head>
<body>
    <h1>Generate Image</h1>
    <form id="image-form" method="POST" action="{{ url('/generate') }}">
        @csrf
        <label for="prompt">Prompt:</label>
        <input type="text" id="prompt" name="prompt" required>
        <button type="submit">Generate Image</button>
    </form>
    <div id="generated-image-container" style="display:none;">
        <h2>Generated Image</h2>
        <img id="generated-image" src="" alt="Generated Image">
    </div>

    <script>
        document.getElementById('image-form').addEventListener('submit', async function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const csrfToken = form.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error + ': ' + (errorData.details || 'Unknown error'));
                }

                const data = await response.json();
                const imagePath = data.image_path;
                const imgElement = document.getElementById('generated-image');
                imgElement.src = imagePath;
                imgElement.style.display = 'block';
                document.getElementById('generated-image-container').style.display = 'block';
            } catch (error) {
                console.error('Error generating image:', error.message);
                alert('Error: ' + error.message);
            }
        });
    </script>
</body>
</html>
