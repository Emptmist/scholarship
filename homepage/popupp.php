<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pop up</title>
</head>
<style>
    .popup .overlay{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-color: rgba(38, 48, 46, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 70%;
            pointer-events: none;
            transition: opacity 0.3s ease;
            display: none;
        }
        .popup .content-pop{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%) scale(0);
            background: #FFF;
            width: 1157px;
            height: 652px;
            z-index: 2;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
            color: #346473;
            
        }
        .popup .close-btn{
            position: fixed;
            top: 20px;
            right: 20px;
            width: 30px;
            height: 30px;
            color:#346473;
            font-size: 25px;
            font-weight: 900;
            line-height: 30px;

        }
        .popup.active .overlay{
            display: block;
        }

        .popup.active .content-pop{
            transition: all 400ms ease-in-out;
            transform: translate(-50%,-50%) scale(1);

        }
</style>
<body>
    <div>
        <div class="popup" id="popup-1">
            <div class="overlay"></div>
                <div class="content-pop">
                    <div class="close-btn" onclick="togglePopup()">&times;</div>
                    <br><br>
                    <h1>title content</h1>
                    <p >content</p>
                        <button onclick="togglePopup()" class="view-btn">Back</button>
                    </div>
            </div>
            <button onclick="togglePopup()" class="view-btn">view</button>
        </div>
    </div>
</body>
<script>
        const faqs = document.querySelectorAll(".faq-dropdown");
        faqs.forEach(faq =>{
            faq.addEventListener("click", ()=>{
                faq.classList.toggle("active");
            })
        })

        function togglePopup(){
            document.getElementById("popup-1").classList.toggle("active");
        }
    </script>
</html>