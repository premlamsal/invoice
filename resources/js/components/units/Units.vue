<template>
 <div>
    <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Units</h1>
          <p class="mb-4">
             <b-button id="show-btn" @click="$bvModal.show('bv-modal-add-unit')" class="btn btn-success" style="margin-top: 8px;">
                       <span class="fa fa-plus-circle"></span>
                     Add Unit</b-button>
          </p>

          <!-- add unit model start -->
                      <b-modal id="bv-modal-add-unit" hide-footer>
                        <template v-slot:modal-title>
                          Add Unit
                        </template>
                        <div class="d-block">
                              <div class="form-group">
                                <label for="Short Name">Short Name</label>
                                <input type="text" class="form-control" placeholder="ex. kg or sq.ft or ltr" v-model="unit.short_name">

                              </div>
                              <div class="form-group">
                                <label for="Long Name">Long Name</label>
                                <input type="text" class="form-control" placeholder="ex. kilogram or square foot or litre" v-model="unit.long_name">
                              </div>
                        </div>
                        <b-button class="mt-3" block>Save</b-button>
                      </b-modal>
            <!-- add unit modal end-->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Units</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Short Name</th>
                      <th>Long Name</th>
                      <th>Updated at</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="unit in units" v-bind:key="unit.id">
                      <td>{{unit.id}}</td>
                      <td>{{unit.short_name}}</td>
                      <td>{{unit.updated_at}}</td>
                      <td>{{unit.long_name}}</td>
                  
                      <td><button class="btn btn-outline-success" style="margin-right: 5px;" @click=editUnit(unit.id)><span class="fa fa-edit"></span></button><button class="btn btn-outline-danger" @click=deleteUnit(unit.id)><span class="fa fa-trash"></span></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
 </div>
</template>
<script>
  export default{

    data(){
      return {

        units:[], //contains all the retrived units from the database

        unit:{} //for form single unit data

      }
    },
    created(){
      //this block will execute when component created
    },

    methods:{
      //methods codes here
      fetchUnits(){



      },
      editUnit(id){
        this.$bvModal.show('bv-modal-add-unit');
      },
      updateUnit(){


      },
      deleteUnit(id){

      }
    //end of methods block
    }

  }
</script>
