<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Form</title>
    <link rel="stylesheet" href="aboutus.css">
    <style>
        *{
    margin: 3px;
    padding: 0px;
    box-sizing: border-box;
    font-family: 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
}
body{
    background-color: rgb(229, 235, 237);
    font-size: 23px;
    }
.heading{
    width: 90%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
    margin: 20px auto;
}
.heading h1{
    font-size: 50px;
   
    margin-bottom: 25px;
    position: relative;
}
.heading h1::after{
    content:"";
    position: absolute;
    width: 100%;
    height: 4px;
    display:block;
    margin: 0 auto;
    background-color: black;
}
.heading p{
    font-size: 18px;
    color: black;
    margin-bottom: 35px;
}
.container{
    width: 90%;
    margin: 0 auto;
    padding:10px 20px;
}
.About{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
.about-image{
    flex: 1;
    margin-right: 40px;
    overflow: hidden;
}

.about-image img{
    max-width: 100%;
    height: auto;
    display: block;
    transition: 0.5s ease;
}
.about-image:hover img{
    transform: scale(1.2);
}
.About-content{
    flex: 1;
}

@media screen and (max-width: 768px){
    .heading{
        padding: 0px 20px;
    }
    .heading h1{
        font-size: 36px;
    }
    .heading p{
        font-size: 17px;
        margin-bottom: 0px;
    }
    
}


    </style>

</head>

<body>


    <div class="Heading">
        <h1>About us</h1>
        <p>Preserve biodiversity, protect animals, and ensure a harmonious coexistence for a sustainable future."</p>

    </div>
    <div class="container">
        <section class="About">
            <div class="about-image">
                <img src="pic (1).jpeg">
            </div>
            <div class="About-content">
                <h2> Uniting Communities, Empowering Conservation</h2>
                <p>In the heart of Indonesia's biodiversity crisis, where the struggle to protect endangered species
                    intensifies,
                    Yayasan Komodo (the Komodo Foundation) has emerged as a beacon of hope. Fueled by a vision of
                    holistic conservation,
                    the foundation identified a critical need for community involvement and launched the ambitious
                    Komodo Hub initiative.
                    Indonesia, blessed with unique and diverse wildlife, faces the imminent threat of losing its iconic
                    species. Despite substantial government investments, the populations of Sumatran Tigers, Javan
                    Rhinoceros,
                    Bali Mynas, Javan Eagles, Tarsius, and Celebes Crested Macaques have dwindled to alarming numbers.
                    The primary culprit is
                    habitat loss, compounded by habitat changes, over-exploitation, invasive species, pollution, and
                    disease.<br><br><br>

                <h1>About Komodo Hub:</h1>
                Designed to be accessible to all, Komodo Hub will serve as an educational powerhouse, offering a
                comprehensive knowledge base on endangered endemic species. Beyond information, the platform will
                empower users to participate actively in conservation programs. Registered users can contribute to
                the knowledge base by sharing their observations, fostering a collaborative approach to
                conservation.<br><br>
                As we march towards the end of 2024, Komodo Hub envisions a nation united in the cause of
                conservation. It is not merely an organization; it is a collective effort to safeguard Indonesia's
                precious biodiversity. Join us on this journey, as we build a future where humans coexist
                harmoniously with nature, preserving the rich tapestry of life for generations to come.





                </p>

            </div>

        </section>
    </div>
    <br><br><br>
    <h2> Privacy and Terms</h2>
    At Komodo Hub, your privacy is paramount. Our Privacy Policy ensures the confidentiality of your data, assuring
    users that their personal information is securely handled. We are committed to transparency, outlining the types of
    data collected and how it's utilized to enhance your experience on our platform. Rest assured, your trust in us is
    our top priority.<br><br>

    <h3>Terms of Use</h3>
    By engaging with Komodo Hub, users enter into a collaborative commitment to conservation. Our Terms of Use
    articulate the rules of engagement, emphasizing responsible utilization of the platform. Users agree to contribute
    positively to our shared mission, fostering a community-driven approach to safeguarding Indonesia's biodiversity.
    Together, we create a digital space dedicated to education, awareness, and conservation.<br><br>

    <h4>Data Protection Information:</h4>
    Komodo Hub values your data and takes proactive measures to ensure its protection. Our Data Protection Information
    details the steps we've taken to safeguard your information, from encryption protocols to secure servers. We adhere
    to industry standards, promising the responsible handling and storage of your data. Your participation in Komodo Hub
    comes with the assurance that your information is treated with the utmost care.
</body>

</html>