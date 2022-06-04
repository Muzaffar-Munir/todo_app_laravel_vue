<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <div class="create-account-form">
      <form @submit.stop.prevent="submit()">
        <div class="form-group mb-4 custom-form">
          <input
            type="text"
            name="text"
            class="form-control"
            placeholder="Enter title of Product/Concept"
            required
            autofocus
            v-model="serviceForm.title"
            :class="[{'is-invalid': errorFor('title')}]"
          />
          <v-errors :errors="errorFor('title')"></v-errors>
        </div>
        <div class="form-group mb-2 custom-form">
          <textarea
            class="form-control foam-border comment-box"
            placeholder="Enter Description of Concept or Product Wanting to Sell"
            rows="6"
            required
            cols="50"
            name="comment"
            v-model="serviceForm.description"
            :class="[{'is-invalid': errorFor('description')}]"
          ></textarea>
          <v-errors :errors="errorFor('description')"></v-errors>
        </div>
        <div class="form-group mb-2 custom-form">
          <input
            type="number"
            name="text"
            class="form-control"
            placeholder="Enter Price of Product/Concept"
            required
            v-model="serviceForm.price"
            :class="[{'is-invalid': errorFor('price')}]"
          />
          <v-errors :errors="errorFor('price')"></v-errors>
        </div>

        <select
          class="registration-select"
          v-model="serviceForm.sales_method"
          required
          :class="[{'is-invalid': errorFor('sales_method')}]"
        >
          <option value>Select Preferred Sales methods</option>
          <option
            v-for="(data, index) of sales_methods"
            :key="index"
            :value="data.id"
          >{{data.title}}</option>
        </select>
        <v-errors :errors="errorFor('sales_method')"></v-errors>
        <select
          class="m-bottom registration-select freelaning-select"
          required
          v-model="serviceForm.industry"
          :class="[{'is-invalid': errorFor('industry')}]"
        >
          <option value>Prefered Industry</option>
          <option v-for="(data, index) of industries" :key="index" :value="data.id">{{data.title}}</option>
        </select>
        <v-errors :errors="errorFor('industry')"></v-errors>

        <div class="form-group mb-2 custom-form">
          <input
            type="text"
            name="text"
            class="form-control"
            placeholder="Enter Target Audience "
            required
            v-model="serviceForm.audience"
            :class="[{'is-invalid': errorFor('audience')}]"
          />
          <v-errors :errors="errorFor('audience')"></v-errors>
        </div>
        <div class="form-group mb-2 custom-form">
          <select
            class="registration-select"
            v-model="serviceForm.location"
            required
            :class="[{'is-invalid': errorFor('location')}]"
          >
            <option value>Enter Target Location</option>
            <option value="suburb">Suburb</option>
            <option value="state">State</option>
            <option value="country">Country</option>
            <option value="none">None</option>
          </select>
          <v-errors :errors="errorFor('location')"></v-errors>
        </div>

        <div class="row mt-4">
          <div class="col-md-6 browser-content create-pic replace">
            <div v-if="data && serviceForm.attachment && serviceForm.attachment.length && !url">
              <img
                class="preview-image-width"
                :src="serviceForm.attachment ? '/images/services/'+serviceForm.attachment : '/assets/images/Untitled-1_10.jpg'"
              />
            </div>
            <div v-if="url && url.length">
              <img :src="url?url:'/images/Untitled-1_10.jpg'" class="preview-image-width" />
            </div>
          </div>
          <div class="col-md-6 tab-responsive">
            <file-upload
              class="btn-browser"
              :post-action="postAction"
              :extensions="extensions"
              :accept="accept"
              :multiple="multiple"
              :directory="directory"
              :size="size || 0"
              :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
              v-model="serviceForm.attachment"
              @input-filter="inputFilter"
              @input-file="inputFile"
              ref="upload"
            >BROWSER</file-upload>
          </div>
        </div>

        <div class="form-group mb-2 custom-form">
          <input
            type="text"
            name="text"
            class="form-control"
            placeholder="Business URL "
            required
            v-model="serviceForm.url"
            :class="[{'is-invalid': errorFor('url')}]"
          />
          <v-errors :errors="errorFor('url')"></v-errors>
        </div>

        <div class="form-group mb-2 custom-form create-section">
          <textarea
            class="form-control foam-border comment-box"
            placeholder="Enter Prerequisites or Requirements for the Role"
            rows="3"
            required
            cols="50"
            name="comment"
            form="usrform"
            v-model="serviceForm.requirements"
            :class="[{'is-invalid': errorFor('requirements')}]"
          ></textarea>
          <v-errors :errors="errorFor('requirements')"></v-errors>
        </div>

        <div class="row detail-form create-detail">
          <div
            class="col-md-12 my-3 create-bottom"
          >Do not display email – email to be sent through UpsellUpscale website!</div>
          <div class="col-12 col-sm-12 col-md-4">
            <button class="btn-save" type="submit">SAVE</button>
          </div>
          <div class="col-12 col-sm-12 col-md-2 or" v-if="!id">OR</div>
          <div class="col-12 col-sm-12 col-md-6 explore-div" v-if="!id">
            <router-link :to="{name:'listFreelancers'}">
              <button class="btn-explore btn-block">Explore Freelance Profiles</button>
            </router-link>
            <a>Upgrade to 12 Months Plan For This Feature</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import validationErrors from "../../mixins/validationErrors";
import { is422 } from "../../utils/response";
import { getSalesmethods, getIndustries } from "../../utils/getDatabseData";
export default {
  props: ["type", "id", "user", "data"],
  mixins: [validationErrors],
  async created() {
    if (this.id && this.data) {
      this.serviceForm = this.data;
      this.serviceForm.attachment = [this.data.attachment];
    }
    this.industries = await getIndustries();
    this.sales_methods = await getSalesmethods();
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  data() {
    return {
      url: null,
      sales_methods: null,
      industries: null,
      accept: "image/png,image/gif,image/jpeg,image/webp",
      extensions: "gif,jpg,jpeg,png,webp",
      minSize: 1024,
      size: 1024 * 1024 * 10,
      multiple: false,
      directory: false,
      thread: 3,
      name: "file",
      postAction: "/index.php/api/user",
      putAction: "/index.php/api/user",
      autoCompress: 1024 * 1024,
      uploadAuto: false,
      status: null,
      loader: true,
      serviceForm: {
        title: null,
        description: null,
        price: null,
        sales_method: "",
        audience: null,
        location: "",
        url: null,
        client_id: null,
        requirements: null,
        attachment: [],
        industry: "",
      },
      status: null,
      errors: null,
    };
  },
  watch: {
    "serviceForm.attachment": function (val, oldVal) {
      if (
        this.serviceForm.attachment &&
        this.serviceForm.attachment[0] &&
        this.serviceForm.attachment[0].blob
      ) {
        this.url = this.serviceForm.attachment[0].blob;
      }
    },
  },
  methods: {
    // submit btn action for create and update
    submit() {
      this.loader = true;
      const data = new FormData();
      data.append("title", this.serviceForm.title);
      data.append("description", this.serviceForm.description);
      data.append("price", this.serviceForm.price);
      data.append("sales_method", this.serviceForm.sales_method);
      data.append("audience", this.serviceForm.audience);
      data.append("location", this.serviceForm.location);
      data.append("url", this.serviceForm.url);
      data.append("client_id", this.user.id);
      data.append("requirements", this.serviceForm.requirements);
      data.append("industry", this.serviceForm.industry);

      if (this.id && this.type == "update") {
        if (
          this.serviceForm.attachment &&
          this.serviceForm.attachment[0] != null &&
          this.serviceForm.attachment[0].file
        ) {
          data.append("attachment", this.serviceForm.attachment[0].file);
        }
        data.append("_method", "PATCH");
        axios
          .post("/index.php/api/service/" + this.id, data)
          .then((response) => {
            this.loader = false;
            if (response.status && response.status == 200) {
              this.$router.push({ name: "clientListServices" });
            }
          })
          .catch((error) => {
            this.loader = false;
            if (is422(error)) {
              this.errors = error.response.data.errors;
            }
            this.status = error.response.status;
          })
          .then(() => {
            this.loader = false;
          });
      } else {
        if (
          this.serviceForm.attachment &&
          this.serviceForm.attachment[0] != null
        ) {
          data.append("attachment", this.serviceForm.attachment[0].file);
        }
        axios
          .post("/index.php/api/service", data)
          .then((response) => {
            this.loader = false;
            if (response.status && response.status == 200) {
              this.$router.push({ name: "clientListServices" });
            }
          })
          .catch((error) => {
            this.loader = false;
            if (is422(error)) {
              this.errors = error.response.data.errors;
            }
            this.status = error.response.status;
          })
          .then(() => {
            this.loader = false;
          });
      }
    },

    // atttachment uploading
   inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Add file

        // Filter non-image file
        // Will not be added to files
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent();
        }
        // Create the 'blob' field for thumbnail preview
        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
        }
      }

      if (newFile && oldFile) {
        // Update file

        // Increase the version number
        if (!newFile.version) {
          newFile.version = 0;
        }
        newFile.version++;
      }

      if (!newFile && oldFile) {
        // Remove file
        // Refused to remove the file
        // return prevent()
      }
    },
    //
    // add, update, remove File Event
    inputFile(newFile, oldFile) {
      if (newFile && oldFile) {
        // update
        if (newFile.active && !oldFile.active) {
          // beforeSend
          // min size
          if (
            newFile.size >= 0 &&
            this.minSize > 0 &&
            newFile.size < this.minSize
          ) {
            this.$refs.upload.update(newFile, { error: "size" });
          }
        }
        if (newFile.progress !== oldFile.progress) {
          // progress
        }
        if (newFile.error && !oldFile.error) {
          // error
        }
        if (newFile.success && !oldFile.success) {
          // success
        }
      }
      if (!newFile && oldFile) {
        // remove
        if (oldFile.success && oldFile.response.id) {
          // $.ajax({
          //   type: 'DELETE',
          //   url: '/upload/delete?id=' + oldFile.response.id,
          // })
        }
      }
      // Automatically activate upload
      if (
        Boolean(newFile) !== Boolean(oldFile) ||
        oldFile.error !== newFile.error
      ) {
        if (this.uploadAuto && !this.$refs.upload.active) {
          this.$refs.upload.active = true;
        }
      }
    },
  },
};
</script>