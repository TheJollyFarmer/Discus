<template>
  <v-form
    @submit="submit"
    @cancel="cancel">
    <v-field grouped>
      <v-select
        v-model="form.channel_id"
        :errors="getErrors('channel_id')"
        :options="channels"
        label="Channels"
        autofocus/>
      <v-input
        v-model="form.title"
        :errors="getErrors('title')"
        class="is-expanded"
        icon-left="user"
        placeholder="Title"/>
    </v-field>
    <v-field>
      <v-wysiwyg
        v-model="form.body"
        name="body"/>
    </v-field>
  </v-form>
</template>

<script>
import api from "../../api";
import Recaptcha from "../../mixins/Recaptcha";
import VField from "../utility/VField";
import VForm from "../utility/VForm";
import VInput from "../utility/VInput";
import VSelect from "../utility/VSelect";
import VWysiwyg from "../utility/VWysiwyg";
import { mapActions, mapState, mapGetters } from "vuex";

export default {
  name: "ThreadFormModal",

  components: {
    VField,
    VForm,
    VInput,
    VWysiwyg,
    VSelect
  },

  mixins: [Recaptcha],

  data() {
    return {
      form: {
        channel_id: "",
        title: "",
        body: ""
      }
    };
  },

  computed: {
    ...mapState(["channels"]),
    ...mapGetters(["getErrors"])
  },

  methods: {
    ...mapActions(["toggleContent"]),

    submit() {
      api.request("post", api.route("threads.store"), this.form).then(url => {
        api.goTo(url);
        flash("Success, your thread has been published!");
      });
    },

    cancel() {
      this.toggleContent("modal").then(() => (this.form = {}));
    }
  }
};
</script>
