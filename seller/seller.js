document.addEventListener(
    "DOMContentLoaded",
    function () {


        const bookForm =
            document.getElementById(
                "bookForm"
            );


        const clientError =
            document.getElementById(
                "clientError"
            );


        const description =
            document.getElementById(
                "description"
            );


        const descriptionCount =
            document.getElementById(
                "descriptionCount"
            );


        const price =
            document.getElementById(
                "price"
            );


        const quantity =
            document.getElementById(
                "quantity"
            );


        const previewText =
            document.getElementById(
                "previewText"
            );


        /*
            Description character counter
        */

        function updateDescriptionCount() {

            if (
                description &&
                descriptionCount
            ) {

                descriptionCount.textContent =
                    description.value.length
                    + " / 800 characters";

            }

        }


        /*
            Price + quantity preview
        */

        function updatePreview() {

            if (
                !price ||
                !quantity ||
                !previewText
            ) {

                return;

            }


            const priceValue =
                parseFloat(
                    price.value
                );


            const quantityValue =
                parseInt(
                    quantity.value
                );


            if (
                priceValue > 0 &&
                quantityValue > 0
            ) {

                previewText.textContent =
                    "RM "
                    + priceValue.toFixed(2)
                    + " each · "
                    + quantityValue
                    + " available";

            }

            else {

                previewText.textContent =
                    "Enter a valid price and quantity.";

            }

        }


        /*
            Description input event
        */

        if (description) {

            updateDescriptionCount();


            description.addEventListener(
                "input",
                updateDescriptionCount
            );

        }


        /*
            Price input event
        */

        if (price) {

            price.addEventListener(
                "input",
                updatePreview
            );

        }


        /*
            Quantity input event
        */

        if (quantity) {

            quantity.addEventListener(
                "input",
                updatePreview
            );

        }


        updatePreview();


        /*
            Client-side validation
        */

        if (bookForm) {


            bookForm.addEventListener(
                "submit",
                function (event) {


                    const title =
                        document
                        .getElementById("title")
                        .value
                        .trim();


                    const author =
                        document
                        .getElementById("author")
                        .value
                        .trim();


                    const genre =
                        document
                        .getElementById("genre")
                        .value;


                    const language =
                        document
                        .getElementById("language")
                        .value;


                    const condition =
                        document
                        .getElementById(
                            "book_condition"
                        )
                        .value;


                    const priceValue =
                        parseFloat(
                            document
                            .getElementById("price")
                            .value
                        );


                    const quantityValue =
                        parseInt(
                            document
                            .getElementById(
                                "quantity"
                            )
                            .value
                        );


                    let message = "";


                    if (
                        title === "" ||
                        author === "" ||
                        genre === "" ||
                        language === "" ||
                        condition === ""
                    ) {

                        message =
                            "Please fill in all required fields.";

                    }


                    else if (
                        isNaN(priceValue) ||
                        priceValue <= 0
                    ) {

                        message =
                            "Price must be greater than 0.";

                    }


                    else if (
                        isNaN(quantityValue) ||
                        quantityValue < 1
                    ) {

                        message =
                            "Quantity must be at least 1.";

                    }


                    if (message !== "") {


                        event.preventDefault();


                        clientError.textContent =
                            message;


                        clientError.hidden =
                            false;


                        clientError.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });


                    }

                    else {


                        clientError.textContent =
                            "";


                        clientError.hidden =
                            true;


                    }

                }

            );

        }


        /*
            Delete confirmation
        */

        const deleteForms =
            document.querySelectorAll(
                ".delete-form"
            );


        deleteForms.forEach(
            function (form) {


                form.addEventListener(
                    "submit",
                    function (event) {


                        const button =
                            form.querySelector(
                                ".seller-btn-delete"
                            );


                        const title =
                            button.dataset.title;


                        const confirmed =
                            confirm(
                                'Are you sure you want to delete "'
                                + title
                                + '"?'
                            );


                        if (!confirmed) {

                            event.preventDefault();

                        }


                    }

                );


            }

        );


    }
);