<!DOCTYPE html>
<html>
    <head>
        <title>Beheer</title>
        <link href="stylesheet/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="containersubmit">
            <div id="containersubmitlogo">
                <img src="img/logo.png" alt="logo">
            </div>
            <div id="form">
                <form action="mailto:email@email.com" method="post">
                    <h1>Video Aanpassen</h1>
                    <div id="formsubmit">
                        <div id="submitrowleft">
                            <input type="text" name="videourl" placeholder="videourl..." class="textfield">
                            <input type="text" name="titel" placeholder="titel van de video..." class="textfield">
                            <input type="text" name="maker" placeholder="Naam van de maker..." class="textfield">
                        </div>
                        <div id="submitrowright">
                            <input type="text" name="catagorie" placeholder="catagorie..." class="textfield">
                            <textarea name="beschrijving" placeholder="beschrijving..."></textarea>
                            <input type="submit" name="submit" value="Voeg video toe..." id="submitbutton">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>