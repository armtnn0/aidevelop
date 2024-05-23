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
        <label for="prompt1">性別:</label>
        <select id="prompt1" name="prompt1">
            <option value="girl">女</option>
            <option value="boy">男</option>
        </select><br>
        <label for="prompt2">髪の色:</label>
        <select id="prompt2" name="prompt2">
            <option value="black hair">黒</option>
            <option value="blue hair">青</option>
        </select><br>
        <label for="prompt3">目の色:</label>
        <select id="prompt3" name="prompt3">
            <option value="red eye">赤</option>
            <option value="green eye">緑</option>
            <option value="brown eye">茶色</option>
        </select><br>
        <button type="submit">Generate Image</button>
        <input type="hidden" id="prompt" name="prompt" required>
    </form>
    <div id="generated-image-container" style="display:none;">
        <h2>Generated Image</h2>
        <img id="generated-image" src="" alt="Generated Image">
    </div>

    <script>
        document.getElementById('image-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const form = event.target;
    const prompt1 = document.getElementById('prompt1').value;
    const prompt2 = document.getElementById('prompt2').value;
    const prompt3 = document.getElementById('prompt3').value;
    const combinedPrompt = `${prompt1}, ${prompt2}, ${prompt3}`;

    // 1つのhidden inputフィールドに結合されたプロンプトを設定
    document.getElementById('prompt').value = combinedPrompt;

    // フォームデータを作成
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
