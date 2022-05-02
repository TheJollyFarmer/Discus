export default {
  data() {
    return {
      grecaptchaKey: process.env.MIX_RECAPTCHA_KEY,
      grecaptchaUrl: "https://www.google.com/recaptcha/api.js?render="
    };
  },

  created() {
    this.addRecaptchaScript();
  },

  methods: {
    executeRecaptcha() {
      grecaptcha
        .execute(this.grecaptchaKey, {
          action: "form"
        })
        .then(token => {
          this.$set(this.form, ["g-recaptcha-response"], token);
        });
    },

    executeWait() {
      setTimeout(() => {
        grecaptcha !== "undefined" && grecaptcha.render
          ? this.executeRecaptcha()
          : this.executeWait();
      }, 200);
    },

    addRecaptchaScript() {
      if (typeof grecaptcha === "undefined") {
        let script = document.createElement("script");

        script.src = this.grecaptchaUrl + this.grecaptchaKey;
        script.id = "recaptchaScript";
        script.async = true;
        script.defer = true;
        script.onload = this.executeWait;

        document.head.appendChild(script);
      } else this.executeRecaptcha();
    }
  }
};
