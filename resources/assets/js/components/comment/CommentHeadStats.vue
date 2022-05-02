<template>
  <div
    class="buttons"
    @click.stop>
    <v-button
      :class="favouriteClass"
      icon="heart"
      @onClick="favouritableEvent">
      {{ comment.favourites }}
    </v-button>
    <v-button
      :class="isBestClass"
      icon="star"
      @onClick="isBestEvent"/>
  </div>
</template>

<script>
import VButton from "../utility/VButton";
import { mapGetters } from "vuex";

export default {
  name: "CommentHeadStats",

  components: { VButton },

  props: {
    comment: {
      type: Object,
      required: true
    }
  },

  computed: {
    ...mapGetters({
      isLoggedIn: "auth/isLoggedIn",
      isCreatedBy: "auth/isCreatedBy",
      isThreadOwner: "auth/isThreadOwner",
      isBestComment: "threads/thread/isBestComment"
    }),

    favouriteClass() {
      return this.comment.isFavourited ? "is-primary" : "is-outlined";
    },

    isBest() {
      return this.isBestComment(this.comment.id);
    },

    isBestClass() {
      return this.isBest ? "is-primary" : "is-outlined";
    }
  },

  methods: {
    favouritableEvent() {
      if (this.isLoggedIn) {
        this.$emit("favouritable", this.comment.id);
      }
    },

    isBestEvent() {
      if (this.isLoggedIn && this.isThreadOwner) {
        this.$emit("isBest", this.comment.id, this.isBest);
      }
    }
  }
};
</script>
