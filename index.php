<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVD Antikvár</title>
    <link rel="stylesheet" href="style.css">
    <style>
    a:link, a:visited, a:active, a:hover {
        text-decoration: none;
        color: white;
        background-color: transparent;
    }
    #cookie-consent {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #000;
        color: #fff;
        padding: 10px;
        text-align: center;
        z-index: 1000;
        }
    #cookie-consent button {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
    
    </style>
</head>
<body>
    <header>
        <h1>DVD Antikvár</h1>
        <nav>
            <ul>
                <li><a href="#home">Főoldal</a></li>
                <li><a href="#informaciok">Információk</a></li>
                <li><a href="#kapcsolat">Kapcsolat</a></li>
            </ul>
        </nav>
    </header>
    <section id="home">
        <h2>Üdvözöljük a DVD Antikvár oldalán!</h2>
        <p>DVD és Blu-ray filmek felvásárlásával foglalkozunk. Kérjük, olvassa el a fontos információkat a felvásárlás menetéről.</p>
        <img src="dvd-collection.webp" alt="DVD gyűjtemény">
    </section>
    <section id="informaciok">
        <h2>Felvásárlási Információk</h2>
        <p>Amennyiben komolyan érdekli a felvásárlás folyamata, kérjük, olvassa el az alábbi fontos információkat:</p>
        <ol>
            <li>Olyan filmgyűjteményeket vásárlunk csak fel, melyek nagy darabszámúak (minimum 50 db), csak és kizárólag eredeti, gyári termékek legyenek, semmilyen körülmények között nem vásárolunk fel írt, másolt DVD-ket, Blu-rayeket.</li><br />
            <li>Eladandó filmjeit rendezze 20-30 darabszámú oszlopokba, hogy gerincük jól látható legyen, készítsen fotót róluk, melyeket küldjön el a info@dvdantikvar.hu e-mail címre elérhetőségeivel és egy esetleges irányárral (nem kötelező!) egyetemben.</li><br />
            <li>Amennyiben úgy ítéljük meg, hogy az Ön által ajánlott gyűjtemény számunkra is érdemleges értékkel bír, felvesszük Önnel a kapcsolatot a megadott elérhetősége egyikén, és egy kölcsönösen kialkudott ár ellenében megvásároljuk gyűjteményét, melyet egy Ön által meghatározott napon futárszolgálattal elszállíttatunk.</li><br />
            <li>E-mailben elküldünk Önnek egy adásvételi szerződést és egy vételi jegyet, melyet kérünk kinyomtatni, kitölteni és aláírni.</li><br />
            <li>A filmgyűjteményt kérjük, hogy úgy dobozolja, csomagolja be, hogy ne sérüljenek a termékek, a csomagba kerüljön bele a kitöltött, aláírt szerződés és vételi jegy, valamint a csomagolás teljesen zárt legyen. A futár viszi az etikettet, Önnek nem kell megcímezni a csomagot.</li><br />
            <li>A gyűjteménye kialkudott ellenértékét a hozzánk való beérkezéstől számítva max. 5 munkanapon belül átutaljuk az Ön által, a szerződésben megadott bankszámlaszámra.</li>
        </ol>
        <p>Ha bármilyen kérdése van a felvásárlással kapcsolatban, keressen minket a 30-9537401-es telefonszámon vagy a info@dvdantikvar.hu e-mail címen!</p>
    </section>
    <section id="kapcsolat">
        <h2>Kapcsolat</h2>
        <form action="submit_form.php" method="post" enctype="multipart/form-data">
            <label for="name">Név:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="email">Telefonszám:</label>
            <input type="tel" placeholder="06301234567" pattern="\06(30|70)\d{3}\d{4}" id="phone" name="phone" required>
            
            <label for="subject">Mivel kapcsolatban ír:</label>
            <select id="subject" name="subject" required>
                <option value="dvd">DVD</option>
                <option value="blu-ray">Blu-ray</option>
                <option value="erdeklodes">Érdeklődés</option>
            </select>

            <label for="message">Üzenet:</label>
            <textarea id="message" name="message" required></textarea>

            <label for="pictures">Képek</label>
            <input type="file" id="files" name="files[]" multiple accept="image/*">
            <div style="background-color:#333; color: white; margin: 10px; width: 100%; text-align: center;">
                <p>Elfogadja az <a href="tajekoztato.php">adatkezelési tájékoztatót</a>.<input type="checkbox" name="check" value="1" required></p>
            </div>
            <button type="submit">Küldés</button>
        </form>

        <div id="cookie-consent">
            <p>Ez a weboldal sütiket használ. Az oldal használatával elfogadja a sütik használatát.</p>
            <button onclick="acceptCookies()">Elfogadom</button>
        </div>
    </section>
    <script>
        function acceptCookies() {
            document.cookie = "cookies_accepted=true; path=/; max-age=" + 60 * 60 * 24 * 30; // 30 nap
            document.getElementById('cookie-consent').style.display = 'none';
        }

        // Ellenőrizze, hogy a felhasználó elfogadta-e a sütiket
        if (document.cookie.split(';').some((item) => item.trim().startsWith('cookies_accepted='))) {
            document.getElementById('cookie-consent').style.display = 'none';
        }
    </script>
</body>
</html>