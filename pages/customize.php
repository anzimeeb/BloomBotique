<?php
include_once 'header.php';
include 'functionsPages.inc.php';
if (!isset($_SESSION['customerEmail'])) {
    header("Location: ../account/login.php?redirect=tocustomize");

}
?>

<body>
    <!-- BANNER IMAGE -->
    <div class="banner2">
        <img src="../images/banner2.jpg" alt="BLOOM BOUTIQUE">
        <h1 class="banner-title">CUSTOMIZE</h1>
    </div>

    <form method="POST" action="customize.inc.php">
        <div class="container">

            <!-- Left side - Form -->
            <div class="form-area">
                <h3>Create Your Own</h3>
                <!-- Size -->
                <div class="section-title">Size</div>
                <div class="scrollable-options" id="size-options">
                    <label class="option-button">
                        <img src="../images/size.png" alt="">
                        <input type="radio" name="size" value="Small"> Small
                    </label>
                    <label class="option-button">
                        <img src="../images/size.png" alt="">
                        <input type="radio" name="size" value="Medium"> Medium
                    </label>
                    <label class="option-button">
                        <img src="../images/size.png" alt="">
                        <input type="radio" name="size" value="Large"> Large
                    </label>
                </div>

                <!-- Wrapper -->
                <div class="section-title">Wrapper</div>
                <div class="options-grid scrollable-options" id="wrapper-options">
                    <label class="option-button">
                        <img src="../images/wrapper.png" alt="">
                        <input type="radio" name="wrapper" value="BLUE.png">Blue Wrapper
                    </label>
                    <label class="option-button">
                        <img src="../images/wrapper.png" alt="">
                        <input type="radio" name="wrapper" value="PINK.png">Pink Wrapper
                    </label>
                    <label class="option-button">
                        <img src="../images/wrapper.png" alt="">
                        <input type="radio" name="wrapper" value="BLACK.png">Black Wrapper
                    </label>
                    <label class="option-button">
                        <img src="../images/wrapper.png" alt="">
                        <input type="radio" name="wrapper" value="GREEN.png">Green Wrapper
                    </label>
                    <label class="option-button">
                        <img src="../images/wrapper.png" alt="">
                        <input type="radio" name="wrapper" value="RED.png">Red Wrapper
                    </label>
                    <label class="option-button">
                        <img src="../images/wrapper.png" alt="">
                        <input type="radio" name="wrapper" value="PURPLE.png">Violet Wrapper
                    </label>
                </div>

                <!-- Main Flowers -->
                <div class="section-title">Main Flowers</div>
                <div class="scrollable-options" id="main-flower-options">
                    <label class="option-button">
                        <!-- 🌹 Red Rose -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Rose/IMG_0599]" min="0" value="0"> Red Rose
                    </label>
                    <label class="option-button">
                        <!-- 🌷 Pink Tulip -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Tulips/IMG_0620]" min="0" value="0">Pink Tulip
                    </label>
                    <label class="option-button">
                        <!-- 🌻 Sunflower -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[SunfloweR/IMG_0624]" min="0" value="0">Sunflower
                    </label>
                    <label class="option-button">
                        <!-- 🌼 Daisy -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Daisies/IMG_0629]" min="0" value="0">Daisy
                    </label>
                    <label class="option-button">
                        <!-- 🌺 Gerbera -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Gerberas/IMG_0633]" min="0" value="0">Gerbera
                    </label>
                    <label class="option-button">
                        <!-- 🌸 Lilies -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Lilies/IMG_0631]" min="0" value="0">Lily
                    </label>
                    <label class="option-button">
                        <!-- 🌸 Peonies -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Peonies/IMG_0627]" min="0" value="0">Peony
                    </label>
                    <label class="option-button">
                        <!-- 🌟 Stargazer -->
                        <img src="../images/red-rose.png" alt="">
                        <input type="number" name="main_flower[Stargazer/IMG_0622]" min="0" value="0">Stargazer
                    </label>
                </div>

                <!-- Fillers -->
                <div class="section-title">Fillers</div>
                <div class="options-grid scrollable-options" id="filler-options">
                    <label class="option-button">
                        🚫
                        <input type="radio" name="filler" value="none">None
                    </label>
                    <label class="option-button">
                        <img src="../images/filler.png" alt="">
                        <input type="radio" name="filler" value="Babysbreath.png">Baby's Breath
                    </label>
                    <label class="option-button">
                        <img src="../images/filler.png" alt="">
                        <input type="radio" name="filler" value="Eucalyptus_.png">Eucalyptus
                    </label>
                    <label class="option-button">
                        <img src="../images/filler.png" alt="">
                        <input type="radio" name="filler" value="Lavender.png">Lavender
                    </label>
                    <label class="option-button">
                        <img src="../images/filler.png" alt="">
                        <input type="radio" name="filler" value="QueenAnneslace.png">Queen's Lace
                    </label>
                    <label class="option-button">
                        <img src="../images/filler.png" alt="">
                        <input type="radio" name="filler" value="Asters.png">Asters
                    </label>
                </div>

                <!-- Ribbon -->
                <div class="section-title">Ribbon</div>
                <div class="options-grid scrollable-options" id="ribbon-options">
                    <label class="option-button">
                        🚫
                        <input type="radio" name="ribbon" value="none">None
                    </label>
                    <label class="option-button">
                        <img src="../images/ribbon.png" alt="">
                        <input type="radio" name="ribbon" value="Satin.png">Satin
                    </label>
                    <label class="option-button">
                        <img src="../images/ribbon.png" alt="">
                        <input type="radio" name="ribbon" value="Patterned.png">Patterned
                    </label>
                    <label class="option-button">
                        <img src="../images/ribbon.png" alt="">
                        <input type="radio" name="ribbon" value="Grossgrain_.png">Gross Grain
                    </label>
                </div>

                <input type="hidden" name="custom_image" id="custom_image">
                <input type="hidden" name="save_customflower" value="1">


                <!-- Card -->
                <div class="section-title">Card</div>
                <textarea class="message-card" name="card"
                    placeholder="Enter your message here..."><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
            </div>

            <!-- Right side - Preview -->
            <div class="preview">
                <div id="preview" style="margin-top: 20px;">
                    <!-- <h4>Live Preview:</h4> -->
                    <div id="main-flower-preview">
                        <!-- Images will be stacked here -->
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Add to Cart -->
    <div class="add-to-cart-container">
        <button type="button" class="reset-btn" onclick="location.reload();">Start Again</button>
        <button type="submit" name="save_customflower" class="add-to-cart" id="savePreviewBtn">Add to Cart</button>
    </div>

    <?php include_once 'footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        document.getElementById('savePreviewBtn').addEventListener('click', function (e) {
            e.preventDefault(); // Stop form submission

            const previewElement = document.getElementById('main-flower-preview');

            html2canvas(previewElement).then(function (canvas) {
                const imageData = canvas.toDataURL("image/png");

                fetch('save_preview.php', {
                    method: 'POST',
                    body: JSON.stringify({ image: imageData }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.text())
                    .then(savedFilename => {
                        // Append the filename to the form
                        const form = document.querySelector('form');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'custom_image';
                        input.value = savedFilename;
                        form.appendChild(input);

                        // Submit the form
                        form.submit();
                    })
                    .catch(error => {
                        console.error("Image save failed:", error);
                    });
            });
        });
    </script>

    <script>
        function updatePreview() {
            const flowerInputs = document.querySelectorAll('input[name^="main_flower["]');
            const previewDiv = document.getElementById("main-flower-preview");
            const filler = document.querySelector('input[name="filler"]:checked')?.value;
            const ribbon = document.querySelector('input[name="ribbon"]:checked')?.value;
            const wrapper = document.querySelector('input[name="wrapper"]:checked')?.value;

            previewDiv.innerHTML = ""; // Clear previous preview

            // Add wrapper first (background)
            if (wrapper) {
                let wrapperImg = document.createElement('img');
                wrapperImg.src = "../images/customize/BOUQUETSL/" + wrapper;
                wrapperImg.alt = "Wrapper";
                wrapperImg.style.position = "absolute";
                wrapperImg.style.top = "0";
                wrapperImg.style.left = "0";
                wrapperImg.style.width = "100%";
                wrapperImg.style.height = "100%";
                wrapperImg.style.zIndex = "5"; // Background layer
                previewDiv.appendChild(wrapperImg);

                let wrapperImgbase = document.createElement('img');
                wrapperImgbase.src = "../images/customize/BOUQUETSL/BASE.png";
                wrapperImgbase.alt = "Wrapper";
                wrapperImgbase.style.position = "absolute";
                wrapperImgbase.style.top = "0";
                wrapperImgbase.style.left = "0";
                wrapperImgbase.style.width = "100%";
                wrapperImgbase.style.height = "100%";
                wrapperImgbase.style.zIndex = "1"; // Background layer
                previewDiv.appendChild(wrapperImgbase);
            }

            // Add main flowers
            // Add a flower container inside the previewDiv
            let flowerAreaDiv = document.createElement('div');
            flowerAreaDiv.style.position = "absolute";
            flowerAreaDiv.style.top = "30%";    // Adjust to your preferred "flower area"
            flowerAreaDiv.style.left = "35%";
            flowerAreaDiv.style.width = "40%";
            flowerAreaDiv.style.height = "20%";
            flowerAreaDiv.style.zIndex = "2";
            flowerAreaDiv.style.pointerEvents = "none"; // Flowers won't block clicks
            previewDiv.appendChild(flowerAreaDiv);

            // Add main flowers
            flowerInputs.forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    const flowerName = input.name.match(/\[(.*?)\]/)[1];

                    for (let i = 0; i < quantity; i++) {
                        let flowerImg = document.createElement('img');
                        flowerImg.src = "../images/customize/FLOWERS/" + flowerName + ".png";
                        flowerImg.alt = flowerName;
                        flowerImg.style.position = "absolute";
                        flowerImg.style.top = Math.random() * 80 + "%";   // Random inside container
                        flowerImg.style.left = Math.random() * 80 + "%";  // Random inside container

                        // Random rotation and flip
                        const rotateDeg = Math.random() * 30 - 15; // -15 to 15 deg
                        const flip = Math.random() < 0.5 ? -1 : 1; // 50% chance to flip
                        flowerImg.style.transform = `translate(-50%, -50%) rotate(${rotateDeg}deg) scaleX(${flip})`;

                        flowerImg.style.width = "70%";
                        flowerImg.style.height = "auto";
                        flowerImg.style.zIndex = "2";

                        flowerAreaDiv.appendChild(flowerImg);
                    }
                }
            });

            // Create filler container
            let fillerAreaDiv = document.createElement('div');
            fillerAreaDiv.style.position = "absolute";
            fillerAreaDiv.style.top = "30%";    // Adjust as needed
            fillerAreaDiv.style.left = "35%";
            fillerAreaDiv.style.width = "40%";
            fillerAreaDiv.style.height = "25%";
            fillerAreaDiv.style.zIndex = "2";   // Base z-index
            fillerAreaDiv.style.pointerEvents = "none"; // Doesn't block clicks
            previewDiv.appendChild(fillerAreaDiv);

            // Add fillers (after main flowers but before ribbon)
            if (filler && filler !== "none") {
                const fillerCount = Math.floor(Math.random() * 6) + 5; // 5 to 10

                for (let i = 0; i < fillerCount; i++) {
                    let fillerImg = document.createElement('img');
                    fillerImg.src = "../images/customize/FILLERS/" + filler;
                    fillerImg.alt = filler;
                    fillerImg.style.position = "absolute";

                    // Random positioning inside filler area
                    fillerImg.style.top = Math.random() * 80 + "%";
                    fillerImg.style.left = Math.random() * 80 + "%";

                    // Random rotation and optional flip
                    const rotateDeg = Math.random() * 30 - 15;
                    const flip = Math.random() < 0.5 ? -1 : 1;
                    fillerImg.style.transform = `translate(-50%, -50%) rotate(${rotateDeg}deg) scaleX(${flip})`;

                    fillerImg.style.width = "60%";
                    fillerImg.style.height = "auto";

                    // Randomize z-index between 2 to 4
                    fillerImg.style.zIndex = (Math.floor(Math.random() * 3) + 2).toString();

                    fillerAreaDiv.appendChild(fillerImg); // Append to filler container
                }
            }

            // Add ribbon last (foreground)
            if (ribbon && ribbon !== "none") {
                let ribbonImg = document.createElement('img');
                ribbonImg.src = "../images/customize/RIBBONS/" + ribbon;
                ribbonImg.alt = "Ribbon";
                ribbonImg.style.position = "absolute";
                ribbonImg.style.bottom = "34px";
                ribbonImg.style.left = "53%";
                ribbonImg.style.transform = "translateX(-55%)";
                ribbonImg.style.width = "50%";
                ribbonImg.style.height = "auto";
                ribbonImg.style.zIndex = "6"; // Foreground ribbon
                previewDiv.appendChild(ribbonImg);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Handle radio clicks (ribbon, wrapper, size)
            document.querySelectorAll('.option-button input[type="radio"]').forEach(input => {
                input.addEventListener('change', function () {
                    // Mark selected visually
                    document.querySelectorAll(`input[name="${this.name}"]`).forEach(groupInput => {
                        groupInput.closest('.option-button').classList.remove('selected');
                    });
                    this.closest('.option-button').classList.add('selected');

                    updatePreview(); // <-- Important: Update preview after radio change
                });
            });

            // Handle number input changes (main flowers)
            document.querySelectorAll('.option-button input[type="number"]').forEach(input => {
                input.addEventListener('input', function (e) {
                    if (parseInt(this.value) > 0) {
                        this.closest('.option-button').classList.add('selected');
                    } else {
                        this.closest('.option-button').classList.remove('selected');
                    }
                    updatePreview(); // <-- Update preview whenever flower quantity changes
                });

                // Also allow clicking the whole button to select/deselect
                input.closest('.option-button').addEventListener('click', function (e) {
                    if (e.target.tagName !== 'INPUT') { // Ignore direct number input clicks
                        const numberInput = this.querySelector('input[type="number"]');
                        if (parseInt(numberInput.value) > 0) {
                            numberInput.value = 0;
                            this.classList.remove('selected');
                        } else {
                            numberInput.value = 1;
                            this.classList.add('selected');
                        }
                        updatePreview();
                    }
                });
            });
        });

        // Keep your working scroll behavior
        document.querySelectorAll('.scrollable-options').forEach(container => {
            container.addEventListener('wheel', function (e) {
                if (e.deltaY > 0) {
                    container.scrollBy({ left: 100, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: -100, behavior: 'smooth' });
                }
                e.preventDefault();
            });
        });

        // This will run every time the size is changed OR a flower quantity is changed
        function setupMainFlowerLimits() {
            const flowerInputs = document.querySelectorAll('input[name^="main_flower["]');
            const sizeInputs = document.querySelectorAll('input[name="size"]');

            function getMaxFlowers() {
                const selectedSize = document.querySelector('input[name="size"]:checked')?.value || 'Small';
                if (selectedSize === 'Medium') return 12;
                if (selectedSize === 'Large') return 20;
                return 6; // Default is Small
            }

            function enforceFlowerLimit(changedInput = null) {
                const maxFlowers = getMaxFlowers();
                let total = 0;

                flowerInputs.forEach(input => {
                    total += parseInt(input.value) || 0;
                });

                if (total > maxFlowers && changedInput) {
                    const overBy = total - maxFlowers;
                    let newValue = (parseInt(changedInput.value) || 0) - overBy;
                    changedInput.value = Math.max(0, newValue);
                    alert(`You can only select up to ${maxFlowers} main flowers for this size.`);
                }

                updatePreview(); // Update bouquet preview
            }

            // Listen to changes on each flower input
            flowerInputs.forEach(input => {
                input.addEventListener('input', function () {
                    enforceFlowerLimit(this);
                });
            });

            // Also listen to size change and re-check limits
            sizeInputs.forEach(input => {
                input.addEventListener('change', function () {
                    enforceFlowerLimit();
                });
            });
        }

        // Call it once when the page loads
        setupMainFlowerLimits();

    </script>

</body>

</html>