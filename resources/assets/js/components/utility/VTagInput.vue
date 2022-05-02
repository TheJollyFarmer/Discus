<template>
  <v-field
    grouped
    multiline>
    <div
      v-for="(tag, index) in collection"
      :key="tag.id || tag"
      class="control tag-control is-marginless">
      <v-tag
        attached
        closeable
        @onClose="removeItem(index)">
        {{ tag }}
      </v-tag>
    </div>
    <v-input
      ref="tagInput"
      :autofocus="autofocus"
      v-model="query"
      :width="width"
      :placeholder="placeholder"
      :validation="false"
      autocomplete="false"
      custom-class="tag-input"
      @typing="handleInput"
      @mention="addItem"/>
  </v-field>
</template>

<script>
import api from "../../api";
import VField from "../utility/VField";
import VInput from "../utility/VInput";
import VTag from "../utility/VTag";
import Tribute from "tributejs";
import debounce from "lodash/debounce";

export default {
  name: "VTagInput",

  components: { VField, VInput, VTag },

  props: {
    placeholder: {
      type: String,
      required: true
    },

    autofocus: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data() {
    return {
      query: "",
      collection: []
    };
  },

  computed: {
    width() {
      let width = 60 + this.query.length * 8;

      return this.collection.length >= 1 ? width + "px" : "";
    }
  },

  mounted() {
    this.initTribute(this.$refs.tagInput.$el.children[0]);
  },

  methods: {
    addItem(e) {
      this.collection.push(e.detail.item.original.username);
      this.query = "";

      this.$emit("added", e.detail.item.original.id);
    },

    removeItem(index) {
      this.collection.splice(index, 1);

      this.$emit("removed", index);
    },

    removeLastItem() {
      if (!this.query.length) this.removeItem(this.collection.length - 1);
    },

    handleInput(e) {
      if (e.which !== 50 && (e.which < 65 || e.which > 90)) {
        e.which === 8 ? this.removeLastItem() : e.preventDefault();
      }
    },

    initTribute(el) {
      new Tribute({
        values: (text, cb) => {
          this.fetchUsers(text, cb);
        },

        selectTemplate: item => {},

        menuItemTemplate: item => {
          return this.menuTemplate(item);
        },

        replaceTextSuffix: "",
        selectClass: "is-active",
        lookup: "username",
        fillAttr: "username"
      }).attach(el);
    },

    fetchUsers: debounce(function(text, callback) {
      api
        .request("get", api.route("users.index", { name: text }))
        .then(data => {
          callback(this.filterUsers(data));
        })
        .catch(() => {
          callback([]);
        });
    }, 500),

    filterUsers(users) {
      return users.filter(user => !this.collection.includes(user.username));
    },

    menuTemplate(item) {
      return `<article class="media">
                <div class="media-left">
                  <figure class="image is-32x32">
                      <img alt="User Avatar" src="${item.original.avatar_path}">
                  </figure>
                </div>
                <div class="media-content">
                  ${item.string}
                </div>
              </article>`;
    }
  }
};
</script>

<style lang="scss">
@import "~tributejs/dist/tribute.css";

.tag-control {
  padding: 0.375em 0 0 0.5em;
}

.tag-input,
.tag-input:active,
.tag-input:focus {
  border: none;
  box-shadow: none;
  max-width: 240px;
}

.tribute-container {
  background-color: white;
  border-radius: 4px;
  -webkit-box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1),
    0 0 0 1px rgba(10, 10, 10, 0.1);
  box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
  padding-bottom: 0.5rem;
  padding-top: 0.5rem;
}

.tribute-container li {
  color: #4a4a4a;
  display: block;
  background-color: white;
  font-size: 0.875rem;
  line-height: 1.5;
  padding: 0.375rem 1rem;
  position: relative;
  text-align: left;
  white-space: nowrap;
  width: 100%;
}

.tribute-container > ul > li:hover,
.tribute-container > ul > li.is-active {
  background-color: whitesmoke;
  color: #0a0a0a;
}

.tribute-container img {
  border-radius: 0.5em;
}

.tribute-container article .media-content {
  display: flex;
  align-self: center;
}
</style>
