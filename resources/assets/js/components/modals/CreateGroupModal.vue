<template>
  <v-form
    is-flat-buttons
    @submit="createGroup(form)"
    @cancel="cancel">
    <v-field>
      <v-input
        v-model="form.name"
        :errors="getErrors('name')"
        placeholder="Name"
        icon-left="user"/>
    </v-field>
    <div class="columns">
      <search-hits
        v-slot="{ hits }"
        class="column is-half">
        <search-hits-list
          :users="form.users"
          :hits="hits"
          @add="addUser"
          @remove="removeUser"/>
      </search-hits>
      <users-list
        :users="form.users"
        @removeUser="removeUser"/>
    </div>
  </v-form>
</template>

<script>
import SearchHits from "../search/SearchHits";
import SearchHitsList from "../search/SearchHitsUserList";
import UsersList from "./UsersList";
import VField from "../utility/VField";
import VForm from "../utility/VForm";
import VInput from "../utility/VInput";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "CreateGroupModal",

  components: {
    SearchHits,
    SearchHitsList,
    UsersList,
    VField,
    VForm,
    VInput
  },

  data() {
    return {
      form: {
        type: "group",
        name: "",
        users: []
      }
    };
  },

  computed: mapGetters(["getErrors"]),

  methods: {
    ...mapActions({
      closeOverlay: "closeOverlay",
      createGroup: "auth/groups/createGroup"
    }),

    addUser(user) {
      this.form.users.push(user);
    },

    removeUser(index) {
      this.form.users.splice(index, 1);
    },

    cancel() {
      this.closeOverlay().then(() => {
        this.form = {
          type: "group",
          name: "",
          users: []
        };
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.columns {
  margin-bottom: 0;
  min-width: 43em;
  .column {
    display: flex;
    flex-direction: column;
    height: 250px;
  }
}
</style>
