<template>
  <div class="column is-half">
    <v-data-scroll
      :data="users.length"
      label="friends">
      <v-list
        :collection="users"
        #list="{ item: user, index }">
        <slot
          :item="user"
          :index="index">
          <users-list-item
            :item="item"
            @onClick="removeUserEvent(index)"/>
        </slot>
      </v-list>
    </v-data-scroll>
  </div>
</template>

<script>
import UsersListItem from "../search/UsersListItem";
import VDataScroll from "../utility/VDataScroll";
import VList from "../utility/VList";

export default {
  name: "UsersList",

  components: { UsersListItem, VDataScroll, VList },

  props: {
    users: {
      type: Array,
      required: true
    }
  },

  methods: {
    removeUserEvent(index) {
      this.$emit("removeUser", index);
    }
  }
};
</script>
