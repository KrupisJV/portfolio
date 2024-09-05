<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Display</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 10px;
        }
        .box {
            background-color: white;
            border: 2px solid white;
            width: calc(33.33% - 20px); /* 3 columns */
            margin: 10px;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
            position: relative;
            display: inline-block;
            vertical-align: top;
        }
        .box img {
            max-width: 100%;
            height: auto;
        }
        .title {
            font-size: 1.5em;
            margin: 10px 0;
        }
        .content {
            font-size: 1em;
            margin: 10px 0;
        }
        .box button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            background-color: limegreen;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .saved {
            border: 2px solid blue !important;
        }
        .saved::before {
            content: "Saglabāts";
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: white;
            color: blue;
            padding: 5px;
            border-radius: 3px;
            font-size: 0.9em;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container" id="content-container">
    <?php
    $jsonData = '[
      {"color":"Red","logos":"https://www.bransonswildworld.com/wp-content/uploads/2015/06/MG_4358-tomato-frog.jpg","title 3":"Random Fact","content":"Did you know that honey never spoils? Archaeologists have found pots of honey in ancient Egyptian tombs that are over 3,000 years old and still perfectly edible!","datee":"06/12/2024","author_role":"Beekeeper"},
      {"color":"Green","logo":"https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Australia_green_tree_frog_(Litoria_caerulea)_crop.jpg/342px-Australia_green_tree_frog_(Litoria_caerulea)_crop.jpg","title":"Trivia","contentins":"The Eiffel Tower in Paris, France, has 20,000 light bulbs that illuminate it at night.","date":"06/05/2024","author_role":"Tour Guide"},
      {"color":"Blue","logo":"https://livingrainforest.org/wp-content/uploads/2018/04/Blue-Poison-Dart-Frog.jpg","title":"Fun Fact","contents":"Octopuses have three hearts!","date":"06/05/2024","author_role":"Marine Biologist"},
      {"color":"Purple","logo":"https://media.istockphoto.com/id/152977214/photo/rare-purple-red-eyed-tree-frog.jpg?s=612x612&w=0&k=20&c=hofedJLY0Uu_kFc73M4dqzI22n9demUSmrYaeLQIN2o=","title":"Art Tip","content":"Mixing red and blue creates purple.","date":"06/11/2024","author_role":"Artist"},
      {"color":"Yellow","logo":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Schrecklicherpfeilgiftfrosch-01.jpg/640px-Schrecklicherpfeilgiftfrosch-01.jpg","title":"Weather Update","content":"Sunny with a high of 25°C today!","date":"09/05/2024","author_role":"Meteorologist"},
      {"color":"Orange","logo":"https://media.istockphoto.com/id/137861665/photo/orange-poison-dart-frog.jpg?s=612x612&w=0&k=20&c=q8QPrdktjlYHWT7hgGz-Gy0cUw7QjhVixpNMFGtNokI=","title 2":"Book Recommendation","content":"Check out \'The Night Circus\' by Erin Morgenstern. It\'s a magical and enchanting read!","date":"06/12/2024","author_role":"Librarian"},
      {"color":"Pink","logo #":"https://i.pinimg.com/736x/1f/4e/35/1f4e3585420e3b25bbb11880f4405a7e.jpg","title":"Random Quote","content":"\"In three words, I can sum up everything I\'ve learned about life: it goes on.\" – Robert Frost","date":"06/05/2024","author_role ?":"Poet"},
      {"color -":"Black","logo":"https://www.ourbreathingplanet.com/wp-content/uploads/2018/12/Black-Rain-Frog-1.jpg","title $":"Black Quote","content is":"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.","date":"06/05/2024","author_role ?":"Poet"}
  ]';

    $data = json_decode($jsonData, true);

    function displayEntry($entry) {
        $logoKey = isset($entry['logos']) ? 'logos' : 'logo';
        $titleKey = array_keys(array_filter($entry, fn($k) => strpos($k, 'title') !== false, ARRAY_FILTER_USE_KEY))[0];
        $contentKey = array_keys(array_filter($entry, fn($k) => strpos($k, 'content') !== false, ARRAY_FILTER_USE_KEY))[0];
        $dateKey = isset($entry['datee']) ? 'datee' : 'date';
        $color = isset($entry['color']) ? $entry['color'] : 'white';
        $logo = isset($entry[$logoKey]) ? $entry[$logoKey] : '';
        $authorRole = isset($entry['author_role']) ? $entry['author_role'] : 'Unknown';

        echo '<div class="box" style="background-color: ' . $color . ';">';
        if ($logo) {
            echo '<img src="' . $logo . '" alt="Image">';
        }
        echo '<div class="title">' . $entry[$titleKey] . '</div>';
        echo '<div class="content">' . $entry[$contentKey] . '</div>';
        echo '<button onclick=\'saveArticle(this, "' . $entry[$titleKey] . '", "' . $entry[$contentKey] . '", "' . $entry[$dateKey] . '", "' . $authorRole . '", "' . $color . '")\'>Saglabāt</button>';
        echo '</div>';
    }

    foreach ($data as $entry) {
        displayEntry($entry);
    }
    ?>
</div>

<script>
    function saveArticle(button, title, content, date, author_role, color) {
        const article = { title, content, date, author_role };
        const savedArticles = JSON.parse(localStorage.getItem('savedArticles')) || [];
        savedArticles.push(article);
        localStorage.setItem('savedArticles', JSON.stringify(savedArticles));
        alert('Raksts ir saglabāts!');
        const box = button.parentElement;
        box.style.border = `2px solid ${color}`;
        box.classList.add('saved');
    }
</script>
</body>
</html>
