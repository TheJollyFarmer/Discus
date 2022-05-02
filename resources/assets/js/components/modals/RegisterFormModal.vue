<template>
  <v-form 
    button-one="Register"
    button-two="Login"
    @submit="register(form)"
    @cancel="openModal({ type:'loginForm', image:'default' })">
    <v-field>
      <v-input
        v-model="form.name"
        :errors="getErrors('name')"
        placeholder="Name"
        icon-left="user"
        autofocus/>
    </v-field>
    <v-field>
      <v-input
        v-model="form.username"
        :errors="getErrors('username')"
        placeholder="Username"
        icon-left="at"/>
    </v-field>
    <v-field>
      <v-input
        v-model="form.email"
        :errors="getErrors('email')"
        type="email"
        placeholder="Email"
        icon-left="envelope"/>
    </v-field>
    <v-field>
      <v-input
        v-model="form.password"
        :errors="getErrors('password')"
        type="password"
        placeholder="Password"
        icon-left="lock"/>
    </v-field>
  </v-form>
</template>

<script>
import VField from "../utility/VField";
import VForm from "../utility/VForm";
import VInput from "../utility/VInput";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "RegisterFormModal",

  components: {
    VField,
    VForm,
    VInput
  },

  data() {
    return {
      form: {
        name: "",
        username: "",
        email: "",
        password: ""
      }
    };
  },

  computed: mapGetters(["getErrors"]),

  methods: {
    ...mapActions(["openModal"]),
    ...mapActions("auth", ["register"])
  }
};
</script>
