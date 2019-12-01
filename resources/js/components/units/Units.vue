<template>
 <div>
    <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Units</h1>
          <p class="mb-4">
             <b-button id="show-btn" @click="showAddModal" class="btn btn-success" style="margin-top: 8px;">
                       <span class="fa fa-plus-circle"></span>
                     Add Unit</b-button>
          </p>

          <!-- add unit model start -->
                      <b-modal id="bv-modal-add-unit" hide-footer>
                        <template v-slot:modal-title>
                          {{modalForName}}
                        </template>
                        <div class="d-block">
                              <div class="form-group">
                                <label for="Short Name">Short Name</label>
                                <input type="hidden" v-model="unit.id" >
                                <input type="text" :class="['form-control']" placeholder="ex. kg or sq.ft or ltr" v-model="unit.short_name">
                                <span v-if="errors.short_name" :class="['errorText']">{{ errors.short_name[0] }}</span>
                              </div>
                              <div class="form-group">
                                <label for="Long Name">Long Name</label>
                                <input type="text" :class="['form-control']" placeholder="ex. kilogram or square foot or litre" v-model="unit.long_name">
                                <span v-if="errors.long_name" :class="['errorText']">{{ errors.long_name[0] }}</span>
                              </div>
                        </div>
                        <b-button class="mt-3" block @click="callFunc">{{modalForName}}</b-button>
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
                      <th>ID</th>
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
                      <td>{{unit.long_name}}</td>
                      <td>{{unit.updated_at}}</td>
                  
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

        unit:{}, //for form single unit data

        modalForName: "",
        modalForCode: 0 ,    

        errors: [],  

      }
    },
    created(){
      //this block will execute when component created
      this.fetchUnits();
    },

    methods:{
      //methods codes here
      fetchUnits(){

        let vm=this;// current pointer instance while going inside the another functional instance
        axios.get('/api/units')
        .then(function(response){
          vm.units=response.data.data;
        })
        .catch(function(error){
          console.log();
        });

        //above and below code provide same result but above code need current instance pointer for value assignmnent 

         //below code donot need current pointer to be save becasue it execute in current block rather then another block that need previous pointer.


        // axios.get('/api/units')
        // .then(response=>{
        //   // console.log(response.data.data)
        //   this.units=response.data.data
        // })
        // .catch(error=>{
        //   console.log(error)
        // })


      },
      showAddModal(){
        this.modalForName="Add Unit";
        // Vue.set(this.modalForName,"Add Unit");
        this.modalForCode=0; //0 for add 
        // Vue.set(this.modalForCode,0);
        this.$bvModal.show('bv-modal-add-unit')
      },
      callFunc(){

        if(this.modalForCode==0){
            this.addUnit();
            // console.log("Add Unit");
        }
        else if(this.modalForCode==1){
            this.updateUnit();
            // console.log("Edit Unit");
        }

      },
      addUnit(){        
        let currObj=this;
        axios.post('/api/unit',this.unit)
        .then(function(response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          currObj.$swal('Info',currObj.output ,currObj.status);

          currObj.$bvModal.hide('bv-modal-add-unit');

          currObj.errors = '';//clearing errors

          currObj.fetchUnits();

        })
        .catch(function(error){
          if (error.response.status == 422){
             currObj.validationErrors = error.response.data.errors;    
             currObj.errors = currObj.validationErrors;
             // console.log(currObj.errors);
            }
        });



      },
      editUnit(id){
        this.modalForName="Edit Unit";
        this.modalForCode=1;// 1 for Edit
        this.$bvModal.show('bv-modal-add-unit');
        currObj.errors = '';//clearing errors
        axios.get('/api/units/'+id)
        .then(response=>{
          // console.log(response.data.unit)
          Vue.set(this.unit, 'short_name', response.data.unit.short_name);
          Vue.set(this.unit, 'long_name', response.data.unit.long_name);
          Vue.set(this.unit, 'id', id);//to send id to the update controller 
        })
        .catch(error=>{
          console.log(error)
        })

      },
      updateUnit(){

        let currObj=this;
        let formData= new FormData();
        formData.append('_method', 'PUT');//add this otherwise data won't pass to backend
        formData.append('short_name',this.unit.short_name);
        formData.append('long_name',this.unit.long_name);
        formData.append('id',this.unit.id);

        axios.post('/api/unit',formData)
        .then(function(response){
          currObj.output=response.data.msg;
          currObj.status=response.data.status;
          // alert(currObj.status);
           
                currObj.$swal('Info',currObj.output ,currObj.status);
                currObj.$bvModal.hide('bv-modal-add-unit');

                currObj.customer.name='';
                currObj.customer.address='';
                currObj.customer.phone='';
                currObj.errors = '';//clearing errors
                
                currObj.fetchUnits();

        })
        .catch(function(error){
             if (error.response.status == 422){
             currObj.validationErrors = error.response.data.errors;    
             currObj.errors = currObj.validationErrors;
             // console.log(currObj.errors);
            }   
        })



      },
      deleteUnit(id){
        let currObj=this;
          this.$swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result)=>{

              if(result.value){
                  axios.delete('/api/unit/'+id)
                  .then(function(response){
                     currObj.output=response.data.msg;
                      currObj.status=response.data.status;
                      // alert(currObj.status);
                      currObj.$swal('Info',currObj.output ,currObj.status);
                      currObj.fetchUnits();

                  }).catch(function(error){
                     currObj.output=error;
                    console.log(currObj.output);
                  })

              }


          });


      }//end of deleteUnit()



    //end of methods block
    }

  }
</script>
