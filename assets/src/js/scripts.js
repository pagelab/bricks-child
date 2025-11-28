// GSAP ScrollTrigger animation.
gsap.registerPlugin(ScrollTrigger);

const animateElements = document.querySelectorAll('[data-animate]');

animateElements.forEach(element => {
  const options = element.getAttribute('data-animate').split(',').reduce((acc, option) => {
    const [key, value] = option.split(':').map(item => item.trim());
    acc[key] = value;
    return acc;
  }, {});

  const defaultStart = 'top 80%';
  const defaultEnd = 'top 80%';

  const splitText = options.splittext === 'true';
  const staggerValue = parseFloat(options.stagger || 0.1);

  if (splitText) {
    const text = element.innerText;
    const chars = text.split('');
    element.innerHTML = chars.map(char => `<span>${char}</span>`).join('');
  }

  gsap.fromTo(
    splitText ? element.children : element,
    {
      x: options.x ? parseInt(options.x) : 0,
      y: options.y ? parseInt(options.y) : 0,
      opacity: options.o ? parseFloat(options.o) : 1,
      rotation: options.r ? 0 : 0,
      scale: options.s ? parseFloat(options.s) : 1
    },
    {
      x: 0,
      y: 0,
      opacity: 1,
      rotation: options.r ? parseInt(options.r) : 0,
      scale: 1,
      scrollTrigger: {
        trigger: element,
        start: options.start || defaultStart,
        end: options.end || defaultEnd,
        scrub: options.scrub ? (options.scrub === 'true' ? true : parseFloat(options.scrub)) : 1,
        pin: options.pin ? (options.pin === 'true' ? true : options.pin) : false,
        markers: options.markers === 'true',
        toggleClass: options.toggleClass || null,
        pinSpacing: options.pinSpacing || 'margin'
      },
      stagger: splitText ? staggerValue : 0
    }
  );
});

// SIMPLE FORM VALIDATION.

// Get the form element
var form = document.getElementById('footer-subscription-form');

// Check if the form exists
if (form) {
    // Get the checkbox and email input elements
    var checkBox = document.querySelector('input[name="your-consent"]');
    var emailInput = document.querySelector('input[name="your-email"]');

    // Check if the checkbox and email input exist
    if (checkBox && emailInput) {
        // Create error message span elements for checkbox and email input
        var checkboxError = document.createElement('span');
        checkboxError.textContent = "Obrigatório consentir com a política de privacidade.";
        checkboxError.className = "wpcf7-not-valid-tip";
        checkboxError.setAttribute("aria-hidden", "true");
        checkboxError.style.display = "none";
        checkBox.parentNode.appendChild(checkboxError);

        var emailEmptyError = document.createElement('span');
        emailEmptyError.textContent = "Insira seu endereço de e-mail.";
        emailEmptyError.className = "wpcf7-not-valid-tip";
        emailEmptyError.setAttribute("aria-hidden", "true");
        emailEmptyError.style.display = "none";
        emailInput.parentNode.appendChild(emailEmptyError);

        var emailInvalidError = document.createElement('span');
        emailInvalidError.textContent = "Insira um endereço de e-mail válido.";
        emailInvalidError.className = "wpcf7-not-valid-tip";
        emailInvalidError.setAttribute("aria-hidden", "true");
        emailInvalidError.style.display = "none";
        emailInput.parentNode.appendChild(emailInvalidError);

        // Add the submit event listener to the form
        form.addEventListener('submit', function(event) {
            if (!checkBox.checked) {
                event.preventDefault(); // Prevent form submission
                // Show error message for consent checkbox
                checkboxError.style.display = "block";
                checkboxError.classList.add("error-visible");
                emailEmptyError.style.display = "none";
                emailEmptyError.classList.remove("error-visible");
                emailInvalidError.style.display = "none";
                emailInvalidError.classList.remove("error-visible");
            } else {
                if (emailInput.value.trim() === "") {
                    event.preventDefault(); // Prevent form submission
                    // Show error message for empty email input
                    checkboxError.style.display = "none";
                    checkboxError.classList.remove("error-visible");
                    emailEmptyError.style.display = "block";
                    emailEmptyError.classList.add("error-visible");
                    emailInvalidError.style.display = "none";
                    emailInvalidError.classList.remove("error-visible");
                } else if (!emailInput.checkValidity()) {
                    event.preventDefault(); // Prevent form submission
                    // Show error message for invalid email input
                    checkboxError.style.display = "none";
                    checkboxError.classList.remove("error-visible");
                    emailEmptyError.style.display = "none";
                    emailEmptyError.classList.remove("error-visible");
                    emailInvalidError.style.display = "block";
                    emailInvalidError.classList.add("error-visible");
                } else {
                    // Hide all error messages if both checkbox is checked and email is valid
                    checkboxError.style.display = "none";
                    checkboxError.classList.remove("error-visible");
                    emailEmptyError.style.display = "none";
                    emailEmptyError.classList.remove("error-visible");
                    emailInvalidError.style.display = "none";
                    emailInvalidError.classList.remove("error-visible");
                }
            }
        });
    } else {
        console.log("Checkbox or email input element not found.");
    }
} else {
    console.log("Form element not found.");
}

// LEADSTER INTEGRATION

// Activate the Leadster form.
function handleButtonClick(event) {
    event.preventDefault();
    event.stopPropagation();
    window.neurolead.open();
}

// Check if the elements exist before adding event listeners.
if (document.getElementById("get-a-quote__hero")) {
    document.getElementById("get-a-quote__hero").addEventListener("click", handleButtonClick);
}
if (document.getElementById("get-a-quote__header")) {
    document.getElementById("get-a-quote__header").addEventListener("click", handleButtonClick);
}
if (document.getElementById("get-a-quote__tasks")) {
    document.getElementById("get-a-quote__tasks").addEventListener("click", handleButtonClick);
}
if (document.getElementById("get-a-quote__footer")) {
    document.getElementById("get-a-quote__footer").addEventListener("click", handleButtonClick);
}
