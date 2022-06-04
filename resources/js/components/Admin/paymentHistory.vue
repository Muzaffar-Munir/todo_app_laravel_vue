<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="create-account-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- <h3>Cancel Account</h3> -->
          </div>
        </div>
      </div>
    </section>

    <section class="create-account">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="update" class="tabcontent" style="display:block">
              <div class="create-account-content"></div>

              <!-- start content-->
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="new-btn">
                      <h5>Payments</h5>
                    </div>
                  </div>
                </div>

                <div v-if="tableData">
                  <vxe-table
                    :data="tableData"
                    resizable
                    :loading="loader"
                    :tooltip-config="{enabled: true, contentMethod: showTooltipMethod}"
                  >
                    <vxe-table-column type="seq" title="#" width="60"></vxe-table-column>
                
                  </vxe-table>
                </div>
                <div v-else>No Payment created yet</div>
              </div>
              <!-- end -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";
export default {
  components: {
    dashboardNavComponent,
  },
  data() {
    return {
      loader: true,
      tableData: null,
    };
  },
  async created() {
    this.tableData = (
      await axios.get("/index.php/api/paymeny-history")
    ).data.data;
    this.tableData = this.tableData.filter((item) => {
        if(item.items){
            return item.items.data;
        }
    });
    console.log(this.tableData);
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  methods: {
    // show tool tip
    showTooltipMethod({ type, column, row, items, _columnIndex }) {
      const { property } = column;
      if (property === "role" || property === "date") {
        if (type === "header") {
          return column.title ? column.title : "";
        } else if (type === "footer") {
          return items[_columnIndex] ? items[_columnIndex] : "";
        }
        return row[property] ? row[property] : "";
      }
      return null;
    },
  },
};
</script>