<template>
  <v-button
    v-if="auth && profileUser !== auth.name"
    :class="classes"
    @click="displayList = !displayList">
    <v-favicon :icon="icon"/>
    <ul 
      v-if="displayList"
      class="dropdown-menu menu-identifier">
      <li v-if="isAuthProfile">
        <a
          href="#"
          @click="acceptFriend">Accept</a>
      </li>
      <li v-if="!status">
        <a
          href="#"
          @click="addFriend">Add</a>
      </li>
      <li v-if="status === 'pending'">
        <a
          href="#"
          @click="unfriend">Cancel</a>
      </li>
      <li v-if="status === 'confirmed'">
        <a
          href="#"
          @click="unfriend">Unfriend</a>
      </li>
      <li>
        <a
          href="#"
          @click="blockFriend">Block</a>
      </li>
      <li v-if="status === 'blocked'">
        <a
          href="#"
          @click="unblockFriend">Unblock</a>
      </li>
    </ul>
  </v-button>
</template>

<script>
import VButton from "../utility/VButton";
import VFavicon from "../utility/VFavicon";
export default {
  components: { VFavicon, VButton },
  props: ["auth"],

  data() {
    return {
      status: false,
      data: false,
      profileUser: this.decodeUrl(),
      displayList: false
    };
  },

  computed: {
    classes() {
      return [
        "button",
        this.status === "confirmed" ? "is-danger" : "is-primary"
      ];
    },

    isAuthProfile() {
      return status === "pending" && this.auth === this.profileUser;
    },

    icon() {
      switch (this.status) {
        case "pending":
          return "hourglass";

        case "confirmed":
          return "user";

        case "blocked":
          return "times";

        default:
          return "plus";
      }
    }
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      // axios
      //   .get(location.pathname + "/friendship/friend")
      //   .then(response => {
      //     if (response.data.length) {
      //       this.data = response.data[0].pivot;
      //       this.status = response.data[0].pivot.status;
      //     }
      //   })
      //   .catch(e => error(e));
    },

    addFriend() {
      // axios
      //   .post(location.pathname + "/friendship")
      //   .then(() => (this.status = "pending"))
      //   .catch(e => error(e));
    },

    acceptFriend() {
      // axios
      //   .patch("/profiles/friendship/" + this.data.id)
      //   .then(() => (this.status = "confirmed"))
      //   .catch(error);
    },

    unfriend() {
      // axios
      //   .delete("/profiles/friendship/" + this.data.id)
      //   .then(() => (this.status = false))
      //   .catch(error);
    },

    decodeUrl() {
      return window.decodeURI(location.pathname.match(/\/profiles\/(.*)/)[1]);
    },

    blockFriend() {}
  }
};
</script>

<style>
</style>
