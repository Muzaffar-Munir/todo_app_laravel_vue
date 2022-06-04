<template>
  <div>
    <!-- this modal is showing content from contact us as well as from cancelled subscriptions data -->
    <div
      class="modal fade model-style"
      id="viewQueryModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              {{ data && data.subject ? data.subject :'' }} {{ data && data.user && data.user.full_name ? data.user.full_name :'' }}
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-left">{{ data && data.message ? data.message :'' }}</p>
              <p class="text-left">{{ data && data.reason ? data.reason :'' }}</p>
              <div class="view-btn view-delete pull-right">
                <button class="delete" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["data"],
};
</script>