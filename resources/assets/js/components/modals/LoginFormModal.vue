<template>
  <v-form 
    button-one="Login"
    button-two="Register"
    @submit="login(form)"
    @cancel="openModal({type:'registerForm', image:'default'})">
    <v-field>
      <v-input
        v-model="form.email"
        :errors="getErrors('email')"
        type="email"
        placeholder="Email"
        icon-left="envelope"
        autofocus/>
    </v-field>
    <v-field>
      <v-input
        v-model="form.password"
        :errors="getErrors('password')"
        type="password"
        placeholder="Password"
        icon-left="lock"/>
    </v-field>
    <v-field>
      <v-checkbox 
        v-model="form.remember" 
        label="Remember me"/>
    </v-field>
  </v-form>
</template>

<script>
import Recaptcha from "../../mixins/Recaptcha";
import VCheckbox from "../utility/VCheckbox";
import VField from "../utility/VField";
import VForm from "../utility/VForm";
import VInput from "../utility/VInput";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "LoginFormModal",

  components: {
    VCheckbox,
    VForm,
    VField,
    VInput
  },

  mixins: [Recaptcha],

  data() {
    return {
      form: {
        email: "",
        password: "",
        remember: true
      }
    };
  },

  computed: mapGetters(["getErrors"]),

  methods: {
    ...mapActions({
      openModal: "openModal",
      login: "auth/login"
    })
  }
};
</script>
