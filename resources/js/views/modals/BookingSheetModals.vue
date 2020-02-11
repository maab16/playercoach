<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditBookingModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addBooking() : updateBooking()">
                    	    
                             <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" v-model="booking.title" class="form-control" placeholder="Booking Title">
                              </div>
                              <div class="form-group">
                                <label for="title">Settings (PUT valid JSON)</label>
                                <textarea class="form-control" v-model="booking.settings" placeholder="Booking Settings" rows="5"></textarea>
                              </div>
                    	    <div class="form-group">
                    	      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    	      <button type="submit" class="btn btn-success">{{ action }}</button>
                    	    </div>
                    	</form>
                    </div>
               </div>
            </div>
        </div>

        <div class="modal fade" id="addEditResourceModal">
          <div class="modal-dialog view-modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title font-weight-bold">Add new resource</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form v-on:submit.prevent="resourceAction == 'add' ? addResource() : updateResource()">
                         <div class="form-group">
                             <label for="permissions" class="col-form-lebel text-md-right">Booking Sheet</label>
                             <multiselect
                                 v-model="resource.resource_type" 
                                 :options="resource_types"
                                 :multiple="false" 
                                 :close-on-select="true" 
                                 :clear-on-select="false" 
                                 :preserve-search="true" 
                                 placeholder="'Pick Resource Type'" 
                                 label="title" 
                                 track-by="title" 
                                 :preselect-first="false"
                                 id="resource_type"></multiselect>
                         </div>
                            <div class="form-group">
                              <label for="title">Title</label>
                              <input type="text" v-model="resource.title" class="form-control" placeholder="Resource Title">
                            </div>
                        <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">{{ resourceAction }}</button>
                        </div>
                    </form>
                  </div>
             </div>
          </div>
      </div>

        <div 
          class="settingModal" 
          :class="{activeSetting:published_booking.isActiveSettingModel}" 
          id="settingBookingSheetModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <div class="text-left">
                          <a href="#" @click.prevent="closeSettingModal"><i class="fas fa-angle-left"></i> Back</a>
                        </div>
                        <div class="text-right"><a href="#">Open in new window <i class="fas fa-sign-out-alt"></i></a></div>
                    </div>
                    <div class="modal-body">
                      <div class="crud-btn-area mb-3 d-flex">
                         <p class="text-white"> Resources</p>
                         <a 
                          href="#" 
                          class="btn btn-success add-btn"
                          data-toggle="modal" 
                          data-target="#addEditResourceModal"
                          @click.prevent="showResourceCreateForm">Add new Resource</a>
                      </div>
                      <div class="table-responsive mt-3" v-if="published_booking.resources.length > 0">
                            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(resource,index) in published_booking.resources" :key="index" :data-id="index+1">
                                      <td>{{ resource.title }}</td>
                                      <td>{{ resource.craeted_at }}</td>
                                      <td>{{ resource.updated_at }}</td>
                                      <td class="action">
                                          <a 
                                            href="#" 
                                            class="btn btn-info" 
                                            @click.prevent="viewResource(index)" 
                                            data-toggle="modal" 
                                            data-target="#viewResourceModal">View</a>
                                          <a 
                                            href="#" 
                                            class="btn btn-success" 
                                            @click.prevent="showEditResourceForm(index)" 
                                            data-toggle="modal" 
                                            data-target="#addEditResourceModal">Edit</a>
                                          <a 
                                            @click.prevent="removeResource(resource.id)" 
                                            class="btn btn-danger">Delete</a>
                                      </td>
                                  </tr>

                                </tbody>
                            </table>
                      </div>
                      <div v-if="published_booking.resources.length <= 0">
                        <p class="alert alert-danger">There is no Resource</p>
                      </div>
                      <div class="crud-btn-area mb-3 d-flex">
                         <p class="text-white"> Business Hours</p>
                      </div>
                      <form @submit.prevent="saveBusinessHours">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="start">Start</label>
                            <datetime 
                              type="time" 
                              input-class="form-control"
                              v-model="published_booking.business_hours.start"></datetime>
                          </div>
                          <div class="col-md-6">
                            <label for="end">End</label>
                            <datetime 
                              type="time" 
                              input-class="form-control" 
                              v-model="published_booking.business_hours.end"></datetime>
                          </div>
                        </div>
                        <div class="form-group text-right">
                          <button type="submit" class="btn btn-success">Save</button>
                        </div>
                      </form>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam magnam nesciunt, sapiente distinctio, est iure totam quidem! Culpa consequatur, eaque necessitatibus possimus magni iusto odit! Incidunt officiis commodi, nisi aspernatur quae voluptas! Sequi id reprehenderit magnam eligendi non. Accusamus corporis voluptates nobis et eos aut nisi quod assumenda, optio. Sit voluptatum ut nemo, perferendis nobis deserunt, minus architecto maiores cum. Sunt vitae eveniet nemo impedit consequatur soluta illo a accusantium excepturi officiis ipsam optio tempora nam porro molestiae, culpa dolores dolorum, vel itaque. Sequi illo, esse, deleniti provident neque architecto sit necessitatibus suscipit aliquam voluptatibus culpa modi vel possimus qui nobis adipisci. Tempore impedit, ipsa? Quisquam ipsam dolorum hic odit facilis corporis quos, veniam eveniet voluptate adipisci quia, aut nobis labore doloremque blanditiis. Officiis fugiat debitis libero, quod impedit iste temporibus repudiandae non tempore blanditiis eum error voluptates cum qui totam exercitationem! Placeat nobis maxime quasi sint reprehenderit facilis voluptate voluptatibus magnam eos deleniti, ab enim libero cupiditate accusantium! Facilis, in fuga. Veritatis beatae suscipit unde, tempora. Porro velit quam eos explicabo ipsam sit ipsum. Ipsam placeat iure porro deleniti itaque, labore sit iusto consequuntur velit quos, nostrum, aspernatur at praesentium, laborum. Aperiam dolorem ipsam repellendus eveniet in, amet id, beatae, accusamus rem tempora officia doloribus totam nihil maxime facilis mollitia incidunt esse inventore, velit vitae aspernatur. Error rerum, sint odio. Quisquam vel at explicabo sint repellat rerum consequatur? Dolorem, et molestias ut non, ratione ullam magni excepturi. Cupiditate vel accusamus reiciendis nemo labore, quam? Delectus natus veniam voluptas, consequatur dolor qui modi cumque odio magnam esse facilis repellat temporibus dolorem nihil omnis minima est doloremque! Maxime explicabo rem quaerat sint. Itaque placeat nam pariatur quisquam distinctio natus autem veniam esse, voluptatem non sint doloremque iure nisi assumenda vel atque ad illum quasi repellat fuga beatae in, odit? Nobis maxime exercitationem tempore. Quod autem et sed non saepe nam hic beatae tempore earum, atque labore commodi, aut voluptates ratione explicabo porro! Corporis aut ducimus esse repellendus aspernatur quia cum impedit dolores, earum dolore! Error tempore in, facilis quasi placeat corrupti dolore suscipit eum rerum recusandae nemo consequatur minus aperiam magni molestias excepturi cum quibusdam! Suscipit sit pariatur, assumenda saepe. Doloremque laborum alias perferendis soluta fuga quod dolores iure accusantium blanditiis necessitatibus reprehenderit facere inventore vitae sequi dolorum recusandae, voluptas quas, veritatis, culpa corrupti esse dolore omnis molestiae ea! Assumenda quasi sequi pariatur, culpa quae id nostrum iure adipisci accusamus illo quod obcaecati aperiam dolorum odio tempora enim. Reiciendis nobis tempora assumenda aspernatur magni minima, ut ducimus. Enim placeat laborum quasi accusamus officiis, obcaecati ipsum, sit, ut voluptatem, voluptas recusandae eum animi reiciendis sapiente alias error dolores saepe voluptate. Facere qui explicabo eveniet quo deleniti quasi non, ullam nisi, id dolorum sequi voluptatem voluptatum iste, ipsam optio, laborum. Eum incidunt laboriosam natus eos libero neque vitae quae, similique culpa quia. Alias sequi ipsum architecto, provident in, consequuntur aperiam suscipit animi! Quo ipsam tenetur sunt doloribus, odio consequatur maxime labore. Quidem laborum neque laudantium perferendis saepe voluptate quae architecto, cumque nulla animi sit tempore voluptatem nobis nisi qui ipsam repudiandae libero quaerat inventore, placeat nihil. Molestias dolorum, adipisci maiores aut cupiditate accusantium ea, dolore laboriosam eveniet voluptas doloribus corporis ducimus sequi illum architecto velit similique debitis! Similique voluptates atque architecto maiores, illo tempore reprehenderit qui assumenda ad accusantium, ut officia placeat, quia minus iste provident aliquid suscipit. A voluptas iure aliquam illum placeat recusandae, vitae sit, quidem! Nesciunt harum quis, temporibus pariatur! Doloremque magni laborum asperiores adipisci laudantium perspiciatis aliquid libero repudiandae cumque labore consectetur architecto quis, earum fugiat, soluta impedit, provident aspernatur reiciendis dolor dignissimos. Unde aperiam iusto provident optio illum neque, quos dignissimos, consequatur possimus quo qui, aspernatur, itaque velit ad cupiditate illo. Iusto nulla quisquam nam odio, quaerat ratione consequatur, nobis aliquam dolore illo est mollitia porro provident autem commodi distinctio hic accusantium nesciunt, possimus! Inventore, fugiat excepturi unde at, repudiandae, provident iusto perferendis quis debitis illo obcaecati neque, suscipit quam blanditiis. Ipsam cumque eius aliquam dolorum, suscipit ab, tenetur nesciunt qui veritatis dolorem quos voluptate, sed esse tempora beatae eligendi illum quas vel enim placeat dolores nemo laudantium quasi sequi doloribus! Quidem vitae cumque quaerat ipsum error, voluptatem consequatur quisquam expedita architecto provident harum eius laboriosam quibusdam totam, nostrum maiores neque id! Laudantium neque in tenetur eos sint. Expedita ratione saepe sequi voluptates ducimus eum ab impedit iste aspernatur vitae! Animi magni, rerum optio nostrum impedit consequatur neque quaerat, praesentium deserunt adipisci maxime vero officia aliquid sapiente delectus, nemo nam veniam expedita hic deleniti! Eaque, eos, deserunt sit temporibus quas ea quos reiciendis et quia voluptates, omnis, praesentium! Nobis numquam rerum non voluptas architecto dolor soluta sapiente asperiores aperiam amet ab ea itaque quibusdam ipsam sequi, laudantium minus deserunt quis illo eligendi explicabo mollitia voluptates! Repellat sapiente ipsam beatae id. Nobis ea quis doloribus delectus eaque culpa necessitatibus optio quae error atque tenetur et, officia, rem labore laborum ipsum eligendi possimus quasi? Asperiores inventore architecto ut modi obcaecati nulla, culpa eaque, in illum quas, dignissimos repudiandae. Vero distinctio ullam officiis, labore minima porro assumenda. Aliquid ullam repellendus alias commodi vitae modi debitis necessitatibus earum perspiciatis ipsam, id obcaecati laboriosam architecto accusamus voluptas numquam error ratione quia, est praesentium rerum animi qui cum amet! Facere porro voluptatum ipsa cumque dolore, temporibus alias hic fugit officia libero id sapiente eius, quia magni, modi. Eaque atque ducimus aliquam delectus vel, provident ratione maxime beatae dolore. Unde vitae totam saepe consequatur labore quo reiciendis nam magnam doloremque qui maxime libero quis minima nisi aspernatur modi quidem, repellendus inventore sit exercitationem sunt atque recusandae a hic consectetur? Esse quis obcaecati id sapiente commodi voluptate dicta molestiae animi totam expedita optio laudantium rerum assumenda excepturi sequi culpa, itaque est sunt omnis exercitationem asperiores praesentium ipsam eligendi! Asperiores ducimus sint harum ab explicabo enim temporibus aliquam fugiat quod distinctio suscipit, voluptates delectus tenetur, illo expedita voluptatum tempora at, dolore nostrum accusantium eaque sunt doloremque praesentium ad. Nobis, dolorum quam! Magni hic vel eligendi atque natus architecto odit sit, a quia enim, aliquam, iure, eum placeat totam deserunt laboriosam distinctio voluptatem fuga consequatur quod corporis possimus repudiandae reiciendis quis? Illo, quam illum sequi possimus numquam eius laboriosam blanditiis. Nesciunt adipisci aperiam voluptate voluptatibus incidunt quibusdam, sunt ipsa minus cupiditate recusandae rem laborum, optio sequi dolores temporibus explicabo quia iure nihil natus nam magni sit, fugiat eaque commodi ut. Reiciendis neque id labore corrupti maxime, optio, ut quos necessitatibus omnis deserunt molestias modi vitae qui nobis repudiandae facere corporis ab! Eaque sit facilis earum expedita dolore voluptates voluptatum ratione non deleniti perferendis itaque numquam eum consectetur laboriosam dolorum nemo aut rem voluptas, at doloribus nam sapiente quaerat dignissimos odio iure. Adipisci voluptatum quod dolorem dignissimos fugit ipsam sequi, earum nostrum iure beatae, ducimus atque! Ducimus fugiat enim autem possimus architecto repellat officiis nihil optio illum alias nam unde at aliquid, ipsa soluta ratione saepe quos esse? Nisi ab at exercitationem totam blanditiis suscipit error? Ipsa sed odit vero placeat necessitatibus laborum quas autem molestiae reiciendis, accusantium nemo nihil amet quos ab recusandae itaque, debitis consequuntur dignissimos iste quo inventore! Facere illum harum necessitatibus magni officia possimus molestiae aperiam nemo quia nostrum reprehenderit a, consequatur culpa nisi voluptate distinctio debitis vero atque ratione. Tenetur voluptatem voluptatibus neque labore maxime quae laborum, nostrum hic dolorem quisquam? Error inventore provident nesciunt hic reprehenderit modi unde voluptate tenetur ab esse, exercitationem ducimus, id, cum? Facilis tempora impedit magnam labore quae porro, voluptatibus ducimus expedita modi dolore dignissimos hic quod dolorem aut, ut tenetur. Similique a accusantium consectetur beatae ab doloribus qui, sit, hic, architecto vero deleniti esse laboriosam dolorum voluptates nostrum! Quaerat eligendi, ex iusto ipsam culpa, cumque consequuntur perspiciatis sequi numquam sed incidunt rem, fuga laborum eius quibusdam consequatur magnam itaque, laboriosam. Deleniti soluta illo, placeat asperiores mollitia voluptatum voluptate nesciunt perferendis explicabo id sint suscipit eligendi quos hic praesentium sunt, rem inventore facere aut. Fuga consectetur laudantium rem nam similique, fugiat laborum porro aut dolorem quaerat, ipsum, doloribus facilis sed ea est et hic commodi beatae aliquid quibusdam quas. Laborum repellendus, cupiditate expedita voluptate voluptatum quod repudiandae ab impedit quaerat dolores, commodi fugiat, doloremque aut pariatur aliquam eum! Nisi nesciunt nobis, reprehenderit laborum. Officia quidem tenetur iste neque earum rerum expedita blanditiis quis delectus dignissimos! Quidem, vitae eum similique rerum id tempora quo consequuntur minima ducimus ipsum cupiditate laborum laboriosam reiciendis modi esse, blanditiis ullam sit perferendis ut dolorum voluptate velit, culpa porro unde. Reprehenderit iure culpa, qui, quas assumenda, cumque aut a quasi in minima repellat eos molestias maiores nemo eveniet at cupiditate asperiores ad deserunt aperiam suscipit perspiciatis dolor. Porro molestias iure velit omnis, consectetur perferendis dolores molestiae, cumque blanditiis facilis rem nisi. Quia incidunt enim, veritatis labore! Deleniti dolorem, ullam officia totam tempora in temporibus, fuga, quibusdam, hic molestias quo error. Nobis corporis aut modi voluptate eveniet, officiis reprehenderit facilis asperiores harum, aliquid perferendis ex voluptatibus. Soluta mollitia laboriosam sit necessitatibus, inventore maxime consectetur tempora qui in itaque cupiditate quas enim ab perspiciatis, placeat dolore. Exercitationem distinctio, illum impedit accusantium ipsa, aliquam. Doloribus, culpa eius ratione temporibus et! Cumque saepe repudiandae culpa voluptate quae molestiae qui, quisquam, id ea maxime placeat asperiores enim aperiam dolorum. Iure architecto vero repellendus eius porro blanditiis assumenda perferendis voluptates, officia eos voluptatem, eligendi maxime ut repellat reiciendis cupiditate dolores ea consectetur adipisci, quo ducimus quidem, suscipit laborum laboriosam obcaecati! Omnis quibusdam, suscipit totam ipsum corporis animi dignissimos ex fugit voluptate quia recusandae tenetur, voluptatibus, voluptas maxime nam natus iste molestias soluta reiciendis libero quidem odio doloremque unde. Vitae maxime laborum, quidem saepe perferendis debitis, distinctio earum eos aliquid quo at nulla expedita quis doloribus veniam quasi incidunt provident nostrum blanditiis. Molestias reiciendis natus ad adipisci. Eos consectetur accusantium dolorem excepturi dolore. Expedita ab fuga eos laudantium itaque sequi veritatis tempora aliquid dicta sit temporibus, hic adipisci cum odit esse atque, natus minima consectetur doloremque ipsum labore praesentium mollitia officia. Quibusdam fugit molestiae minima delectus blanditiis dicta quo, quis expedita facere laboriosam, commodi vel nam iure? Non, ducimus dolorem odit expedita placeat quisquam, nobis? Consectetur ea qui magni dolore! Asperiores, dolorum sunt iusto qui? Quas, aperiam dignissimos, obcaecati sed soluta possimus blanditiis, itaque maxime ipsum odit odio magni excepturi molestiae ab temporibus magnam error dolorum consequatur distinctio quae ipsa minus beatae voluptates? Quasi quaerat libero blanditiis, commodi explicabo sequi facilis eum, voluptas odio est fugit hic nemo. Veniam quos itaque fuga, ipsam ipsum enim dolorum labore non ullam velit sint quo maxime nam iure sed reprehenderit harum exercitationem aperiam debitis, culpa, deserunt commodi doloremque voluptatem. Odio sed deleniti asperiores, ea minus! Esse odio libero dolores animi rerum facilis, aperiam, sunt, sapiente temporibus harum optio omnis! Dolorem corrupti aliquid ab mollitia quos quaerat repudiandae culpa iste asperiores sint veritatis suscipit cumque, unde quae temporibus sunt alias, perferendis repellat obcaecati sequi. Quia architecto aperiam minima, quaerat id debitis ea atque numquam officia praesentium quos at aspernatur fuga perferendis accusantium porro tenetur earum molestias reiciendis iste voluptate labore soluta! Asperiores error delectus unde a nisi commodi hic, enim veritatis libero debitis vel eveniet consequatur quidem temporibus blanditiis facere tempore accusamus sed quae rerum dolorem, quo deleniti corrupti. Architecto dolor non deleniti dolores, et molestias iste voluptate necessitatibus asperiores officia ex eligendi corporis hic vel saepe tempora vitae nam aliquam aut ipsum reiciendis! Dolor sed eos quasi sapiente quas at fuga, aut aliquid veniam magnam asperiores, ab et. Accusantium eos consectetur cumque expedita nisi accusamus ex, excepturi porro voluptatem quod quasi ratione officia tempora provident dolore molestias iure repellat veniam quaerat perferendis qui rerum tempore eius saepe. Quasi, ipsam. Expedita accusantium dolorum laudantium adipisci a, dolore, obcaecati ut, unde neque velit soluta reprehenderit id quasi, temporibus doloremque suscipit rem incidunt laborum omnis odio. Hic accusamus repellendus, nihil molestiae quaerat id natus dignissimos blanditiis qui excepturi, reprehenderit fugiat nisi, praesentium fugit non unde mollitia. Ipsum sint atque minus ab distinctio ipsa culpa magni quam illo, itaque iste laborum incidunt vel exercitationem tempore perspiciatis eveniet harum doloribus alias ad neque, repellat. Est nobis dolores, officia molestiae! Dolores sapiente, qui expedita vero exercitationem autem necessitatibus odio cum omnis fugit velit inventore. Magnam fuga harum omnis quibusdam ad, reiciendis deleniti quo. Nostrum ducimus quo ut nesciunt possimus provident, quasi, quisquam delectus eos consequuntur modi ea officia incidunt, magnam! Magni labore, magnam ipsam animi quam sint quod eaque vel ducimus reprehenderit, voluptatum nobis laudantium, provident harum nulla est iure. Similique modi non quibusdam quia, voluptates beatae, rerum quo qui mollitia vero tenetur accusamus nihil nemo? Ipsa corrupti ipsum consequuntur, temporibus voluptas repudiandae et fugit dolorum molestias, vero, quidem quo incidunt qui ullam necessitatibus consequatur. Similique nulla esse aperiam officia, magni commodi nam quaerat. At cumque minus similique saepe culpa praesentium voluptate ad explicabo aut perspiciatis officia, autem nam ullam, nihil harum! Fugiat porro qui praesentium id eaque, ea assumenda impedit, quibusdam rerum ipsam perspiciatis neque aut, officia reprehenderit iure consequuntur magnam eius. Amet perferendis modi quia ex ab soluta aspernatur dolorum ipsam blanditiis quas sapiente eos consequatur eligendi ducimus quae, odit quod aliquam molestias asperiores neque provident quasi laudantium. Ratione exercitationem numquam vitae distinctio quod quae commodi facilis, nostrum deleniti, ipsum a ad reprehenderit. Atque neque tempore esse nihil obcaecati enim maxime similique a sit ad, nostrum sint sunt rem vel unde necessitatibus, nobis tenetur omnis accusamus distinctio? Eius, libero consectetur facere recusandae labore quam deserunt ratione unde provident veniam itaque, nisi minus voluptas ipsum. Itaque ea harum debitis eveniet eius. Non, totam quisquam odio praesentium deserunt impedit a delectus error temporibus illum repellendus. Veritatis unde mollitia illo dignissimos iure ut impedit cupiditate dolor quam sapiente dolorum, consequatur obcaecati minus inventore debitis beatae aliquid ducimus at illum architecto dolorem accusantium error similique voluptate. Cum accusantium ab consectetur pariatur vel repellendus nemo eligendi asperiores magni maiores, vero nisi explicabo obcaecati, molestias consequuntur illo porro omnis quas quia voluptate facere error assumenda dolorem deleniti. Blanditiis, sed, tempore! Saepe soluta neque reiciendis quod voluptas repellendus nostrum provident cumque praesentium incidunt blanditiis, assumenda dicta quam fuga consequuntur laborum maxime eaque optio ex ut tempore rerum totam ad minus! Dolor recusandae excepturi reiciendis ipsa, nam vel culpa laboriosam quia rem aspernatur. Distinctio ex a, facere rem, qui commodi, nobis unde sequi, accusamus magni alias ipsa. Velit nesciunt hic earum quam. Vel aliquid incidunt commodi corporis illum, voluptates adipisci est nisi explicabo inventore? Ipsum dolores iste quaerat sed saepe quod eos quae laboriosam cupiditate voluptatum corrupti, quibusdam porro praesentium nobis possimus commodi nulla veritatis. Reiciendis tempora sint saepe qui ea nam esse a autem? Eius placeat, iste ipsam perspiciatis dolores nisi iure nulla? Dolor magni ea dolorem architecto voluptate necessitatibus voluptates illum delectus autem, ipsum, qui adipisci accusamus aspernatur, labore obcaecati tempora! Rem voluptatem, quam inventore. Rerum doloribus, repellendus! Modi fugiat quaerat atque dolorum, numquam consequatur eos odit iure tempore nam sapiente reprehenderit at soluta adipisci voluptatum obcaecati asperiores eligendi reiciendis nulla cumque molestiae, suscipit dicta inventore maxime explicabo! Est animi rem fugit ad velit debitis. Repellat repellendus id placeat a soluta, ipsum fugit alias quod nemo numquam minima, nulla officia nesciunt provident, animi corrupti quasi voluptas aliquid asperiores nostrum natus in. Beatae, aliquam ab eum voluptatum numquam ullam laboriosam ea asperiores, excepturi in blanditiis voluptatem eos magnam incidunt consequuntur, impedit autem dolorem non nisi minima earum voluptas. Molestiae voluptatibus ducimus enim amet maiores, accusamus nesciunt temporibus sapiente molestias quae repellendus quam eos unde quaerat blanditiis obcaecati modi beatae aliquid aspernatur, necessitatibus aperiam labore est perferendis voluptates! Repellendus eos ex libero, numquam fugit. Impedit eaque hic, placeat, laboriosam perferendis, repellat maiores quidem velit ab neque, optio minus. Perferendis ea quidem non culpa ad consectetur praesentium ipsam veniam quo. Aperiam quos nemo, incidunt ad placeat eum, illum obcaecati est id. Odit accusamus obcaecati voluptates facere necessitatibus recusandae, excepturi atque ipsam harum vero, eveniet, perferendis cum. Soluta voluptates dignissimos quae molestiae inventore expedita perspiciatis, voluptatibus temporibus autem, debitis aliquid atque reprehenderit qui ipsam aliquam laboriosam a! Harum at ipsum eos reprehenderit dolor autem labore quam laudantium voluptatem eveniet debitis odit necessitatibus, vitae? Debitis, velit necessitatibus odio odit alias! Porro dignissimos tenetur ratione blanditiis nobis qui repellendus sint eius quaerat commodi distinctio libero aliquid facere corporis vel nemo vero fugiat accusantium in dolorem, odit beatae sequi unde. Aliquid numquam officia asperiores nulla blanditiis, nihil cum molestiae rem suscipit eius commodi, fugiat expedita quasi vero, esse. Doloribus nesciunt, alias expedita? Doloremque laborum tempora reiciendis veritatis enim dolores, officiis aperiam! Illo dolorem, in. Rerum dicta nam maxime iste. Adipisci veniam nulla asperiores distinctio quis soluta optio facilis ipsa eligendi sequi neque obcaecati non aspernatur repellendus, facere, voluptatem voluptatibus ullam voluptatum aliquam deleniti nobis deserunt molestiae atque, eaque provident? Architecto voluptates ipsa officia dolore amet accusamus ab earum asperiores quia obcaecati, quisquam pariatur accusantium rem. Consequuntur voluptatibus, nesciunt expedita ea repudiandae quis earum accusamus exercitationem sed nobis necessitatibus dolores incidunt cupiditate autem dolor quo voluptatem quia, quaerat, in provident explicabo ipsam. Reprehenderit aliquid tempore assumenda maiores labore magni ipsum blanditiis, accusantium sed corporis nulla, architecto magnam sapiente ex aspernatur pariatur numquam laborum? Alias nostrum, sapiente exercitationem veritatis soluta veniam aperiam ab facilis explicabo, porro reprehenderit deserunt maiores possimus. Eos molestiae architecto, similique odio optio cumque, consequuntur aspernatur repellendus neque ea obcaecati tempore sapiente alias dolores rem provident. Debitis saepe blanditiis eos veritatis laborum numquam eaque delectus dolor, dignissimos natus ipsum sint dolores neque sed, voluptatem aspernatur ab tempore eligendi itaque pariatur a. Excepturi, deserunt, consectetur. Ea sit dolor quaerat, tempore non blanditiis iusto eligendi, aut at nisi maiores nihil quos vero! Vero expedita officiis reprehenderit nobis ut maiores quod accusamus iusto quos repellat dolorum, architecto magni, sapiente similique voluptates labore dolores odit! Sapiente dolorum aliquam labore vitae rem, saepe veniam, dolore quibusdam expedita natus soluta ab, quaerat sit fuga! Voluptatem iusto, illo, blanditiis porro accusantium quis corporis dolorum accusamus hic molestiae ipsum ullam, voluptatibus! Mollitia at quae hic optio ratione neque deserunt quis, dolorem, perferendis doloribus maiores? Vitae libero fugit deserunt omnis, optio sunt illum repellendus aliquid placeat, corporis quam perspiciatis, repudiandae similique. Nesciunt culpa fugiat, autem obcaecati voluptates quos asperiores magnam praesentium officiis nulla vel? Quas, incidunt, ipsum! Animi quas repellat aperiam maiores sed illum rem tempore earum, nesciunt cupiditate reprehenderit eum, alias corporis voluptates accusamus in ratione praesentium dolor dicta possimus reiciendis mollitia facere. Ratione itaque, iure molestiae. Magni deserunt, error facilis voluptas eligendi! Natus, neque, rem! Cum unde saepe, eaque atque fugit, dolores repellat, quidem eligendi excepturi voluptatibus soluta, iusto pariatur hic sint asperiores. Officiis qui recusandae, quam numquam quaerat rem non sint optio excepturi, doloribus dignissimos hic, consequatur accusantium quo possimus totam repellendus debitis autem. Perferendis expedita iusto numquam voluptatum omnis suscipit veritatis labore illo architecto autem error, accusamus natus sed blanditiis libero odit est debitis similique sit distinctio magni adipisci possimus! Praesentium porro cum, repudiandae, id saepe sed iste libero et, laborum sunt obcaecati. Vel voluptates, et, ad consectetur cum, ipsam harum asperiores voluptate incidunt provident sequi delectus. Rerum eveniet explicabo quasi illo debitis ad impedit, iure maxime praesentium enim provident, aut nostrum tempore odio cupiditate nihil nesciunt quibusdam. Eos vel cumque consequuntur eum neque quisquam dolore aliquid perferendis pariatur inventore necessitatibus error, dolorem, adipisci explicabo quasi non voluptas suscipit! Nulla architecto quibusdam quam eum iusto illo ducimus eveniet animi mollitia officiis possimus placeat impedit qui sit, nobis inventore quae corporis at repellat enim omnis aliquam recusandae consectetur ipsa. Atque libero ad laboriosam esse illum odio ab placeat nemo, repellat commodi explicabo neque, veniam ducimus. Aperiam nemo tempore ullam excepturi nisi nostrum ipsam nihil sunt consectetur rerum saepe pariatur, odit, velit consequuntur expedita numquam iusto. Obcaecati beatae debitis, voluptatibus voluptates quibusdam accusamus tempora similique optio mollitia ab nisi neque natus dolorum pariatur iste laboriosam aliquid magnam quaerat quidem a ex! Recusandae hic iure sapiente voluptates eligendi veritatis dolor sunt, soluta amet nam. Beatae, laborum quam alias nam eligendi in aperiam perspiciatis veritatis ipsum magni doloremque et excepturi debitis quasi aliquam veniam cupiditate facilis, libero asperiores officiis fugiat doloribus ipsam. Sit, culpa dolore repellendus dolorum odio tenetur similique a, quas perferendis ipsa consequuntur fuga saepe quia. Dolore quos quia, numquam, nam velit recusandae ipsam cumque architecto libero? Quis, perferendis, aperiam dolor at beatae fugit consectetur expedita quos quasi laborum. Ex accusantium fuga maiores tempora dolor quisquam enim eos, aut consequuntur laboriosam impedit, ducimus iure cum in, a libero sunt perferendis hic ipsa facere adipisci, sint numquam! Voluptates facere, quas perspiciatis repellat voluptas sequi? Debitis, a iure minima eos. Repellat nihil odio, inventore sequi non harum, nostrum nobis totam, aliquid voluptatibus cum incidunt vel labore! Harum laboriosam ex, similique doloribus, nemo dolores officiis incidunt, libero enim praesentium ducimus quas cupiditate facilis inventore, nihil aspernatur veritatis consectetur ad temporibus hic minus aliquid maxime quos totam eum. Voluptatum inventore quae libero, repudiandae rem consequatur dolorum facilis laudantium saepe fuga dolor numquam aperiam aspernatur! Ducimus, provident assumenda? Eaque earum illo sequi, facilis dignissimos! Dolore accusantium ea nesciunt modi vel illo laudantium repellendus quae, fugiat natus at esse nulla dicta nisi sunt, ipsam necessitatibus. Ipsum sapiente repellat totam, blanditiis commodi omnis pariatur ipsam libero corporis provident voluptatum fuga quos, nemo quod tempora a voluptates impedit velit explicabo sed voluptatibus saepe nihil officiis iste. Ad ipsa in dolores dolor hic saepe, blanditiis neque rem sed, voluptate, provident odit rerum est iure a doloremque ab? Minima sequi hic, ad error nostrum blanditiis consequatur numquam, quia sit nam molestias non iure architecto nulla et rerum magnam culpa asperiores inventore repellat nemo, eveniet similique! Voluptate ullam incidunt saepe quae, itaque magnam magni placeat odio, officia. Error libero, nam optio numquam dolorum praesentium atque quas! Nobis repudiandae natus voluptatibus sunt voluptatem quia necessitatibus enim impedit ipsa sit eaque, dignissimos adipisci ex voluptas porro neque aliquid ab in cum, maiores iure nihil! Repellendus quos, magnam placeat nihil, earum labore pariatur perspiciatis nemo quaerat veritatis sequi est nulla ratione similique illum assumenda sapiente cumque numquam. Quae quo, beatae incidunt, neque impedit dolores et illum. Perspiciatis pariatur doloremque ipsa ad eum accusantium voluptas, delectus odio laudantium laborum. Doloremque voluptates fuga asperiores unde aspernatur quibusdam qui. Saepe perferendis illum iste doloremque sint alias blanditiis quidem tempore dolorum dicta aliquam ab laborum vitae tempora voluptas sapiente sit, facilis enim obcaecati quasi. Magni molestias nostrum dolor reiciendis laborum. Doloremque ullam earum aperiam voluptatibus porro, nihil dicta quo magnam! Sit debitis tempora, aliquid enim, magni, minima vitae praesentium cupiditate saepe id alias velit possimus porro. Voluptate doloremque ullam dolorum quaerat, suscipit illo dolores natus ipsa cumque laborum. Tenetur omnis numquam maiores excepturi unde, laborum dicta labore corporis. Tempore sint necessitatibus, repellendus, nihil nisi et, ex, ea similique accusamus omnis repudiandae. Aperiam dignissimos veniam iste nemo, quo delectus ut molestiae similique, praesentium autem numquam culpa id hic ducimus eius doloribus quod quisquam est quis repellat deleniti sit suscipit reprehenderit, officiis. Commodi aliquid aspernatur assumenda ab, aliquam odit quod maxime iste, id rerum saepe expedita? Quod optio est obcaecati illum blanditiis quas eveniet ad rem consectetur culpa quos aperiam laboriosam at, deleniti tempora facilis quibusdam, ex natus quia esse quidem id laborum aliquam libero? Tempore totam ipsam reprehenderit dolores eum unde assumenda doloribus reiciendis est numquam. Atque molestias at quam neque, et, modi, magni laborum, esse commodi explicabo quae nesciunt totam doloribus dolores impedit aliquam sed corporis facilis praesentium possimus. Aperiam, dolore fuga voluptates alias similique dicta quasi possimus. Accusamus enim ut omnis atque vitae possimus quos quibusdam labore officia laborum, aperiam officiis ea tempora doloremque, minus itaque repellendus consequuntur! Illo tempora quidem iste hic adipisci. Suscipit ex, molestias numquam consectetur accusamus deleniti pariatur sequi quibusdam magni repudiandae veniam beatae praesentium reprehenderit saepe, ipsam similique libero. Fugit assumenda voluptate, aperiam inventore quo eaque quam totam id in quod. Culpa quo a, quas nemo eligendi atque! Iure neque, blanditiis nulla, magnam repudiandae quibusdam consectetur a saepe similique. Minima illum laudantium harum, vitae sit ipsa dolores corporis reprehenderit, maxime magnam sint labore. Architecto repellat aliquid impedit, eligendi molestiae, quos distinctio perferendis qui id officia expedita doloribus dignissimos necessitatibus exercitationem animi amet nulla dolor quisquam voluptatum dolorem ut quasi quia fuga eos! A sunt totam eveniet ex. Similique id sapiente sit! Cum atque nulla nisi maiores, fugit non deleniti, dignissimos in aspernatur neque expedita sequi quisquam iure beatae assumenda est ullam suscipit veniam sit. Ad repellendus ullam, quasi rem necessitatibus, reiciendis omnis incidunt hic ducimus explicabo odio quaerat aut molestiae, perferendis modi iusto sit. Deserunt assumenda, dolorem accusantium ut necessitatibus tempora consequatur nam nisi, repellendus minima ipsam, nobis nulla magni quasi quos est quisquam dolor ad. Amet maxime, possimus nesciunt id, beatae velit odit deleniti. Repellendus, eum ratione. Dolorem quos repellendus aut nihil ex, adipisci eaque tempora ab, consequuntur rerum eum, eligendi atque impedit distinctio! Adipisci dolorem eos odio necessitatibus autem nostrum natus deserunt labore ullam, commodi quaerat doloribus amet fuga. Eos atque minus numquam, nihil velit illo accusantium, temporibus maxime odio officiis, expedita dolorem facere dolores in ipsa nobis voluptatibus ab veritatis enim. Voluptates, adipisci ex eius optio atque molestias eaque, repellendus deserunt eum quibusdam cumque modi odio iusto quas accusantium tempora sunt eos praesentium odit in officia repudiandae iste earum, impedit! Totam nisi quis expedita blanditiis neque dolor alias nam veniam impedit, deserunt culpa cupiditate, autem repellat, qui ullam voluptatem necessitatibus. Fugit eaque accusantium ex obcaecati eius quasi nulla maiores accusamus blanditiis fugiat dolores vel, quidem et, veritatis. Nobis ducimus delectus iusto consequuntur perspiciatis ullam reiciendis temporibus! Maiores velit culpa accusantium, ex dicta rerum doloremque, fuga earum distinctio, labore at eos nulla, doloribus autem. Provident temporibus est quo! At impedit cumque, voluptate enim provident, repellendus quaerat vitae modi omnis, delectus in! Repudiandae pariatur dignissimos, veniam tempore commodi nobis excepturi quaerat, recusandae eveniet quae eum amet eius voluptas, a eligendi, ducimus fugiat expedita! Rerum ad doloremque expedita nobis dolorum voluptate harum ipsum totam mollitia iusto, nostrum eveniet placeat provident, sapiente accusamus voluptatum soluta maiores eum id eligendi laborum libero. Debitis, quibusdam. Accusamus provident neque placeat natus, vitae, ipsam voluptatibus necessitatibus fugit adipisci dolorem maxime doloremque error nisi sapiente repellendus, cum, praesentium? Laborum fuga doloremque dolores optio impedit modi ducimus error rem, illum distinctio id temporibus fugit sit animi. Beatae ut quas, libero fuga facere adipisci voluptate quia, voluptatum modi, nisi animi. Soluta suscipit et laudantium adipisci enim. Repudiandae vero, quasi earum doloremque voluptatem sequi sapiente, quo doloribus quos dolorum natus iure dicta saepe rerum esse dolore praesentium voluptatibus minima delectus et quis maxime. Ipsam at debitis assumenda, excepturi neque aspernatur placeat atque laboriosam fugit ratione impedit minus quo est nam voluptatum? Numquam doloribus facilis tempore delectus, iure error inventore, illum cum provident ex ab dignissimos, aut quam. Totam vitae, inventore consequatur ipsum hic, expedita ad incidunt natus molestiae itaque quidem eius iure veritatis aperiam quo impedit magni culpa consequuntur facilis laboriosam nisi reiciendis repudiandae. Unde cumque hic, veritatis provident animi, nemo cum dolor quasi, aliquid, ipsum libero rerum accusamus harum ducimus quos minus! Aliquid consequatur reiciendis amet assumenda laboriosam beatae at ratione totam repudiandae architecto qui dolor et esse, quisquam nihil saepe possimus, consectetur ipsa porro nisi praesentium voluptas nulla. Consequuntur illo corporis, praesentium ab amet odit eos facilis vero debitis mollitia, qui. Ab sapiente, repudiandae modi nulla nobis id reprehenderit facere harum in, debitis voluptatum ipsam expedita placeat maiores suscipit obcaecati iure quia dolor commodi! Illum esse neque minus delectus sed! Eaque et distinctio ipsam amet, ratione adipisci magnam aspernatur nemo mollitia beatae officia ad deleniti quia dolorem eligendi molestiae nisi, autem odit, porro. Debitis illum, ratione at reiciendis placeat fugit fugiat similique praesentium nam repudiandae harum incidunt corporis omnis esse eligendi, impedit necessitatibus minima doloremque adipisci! Ullam similique ducimus rerum, odit dolorem voluptas illum error incidunt nulla fugit. Laudantium in iste delectus reprehenderit deleniti laboriosam ad iure, necessitatibus voluptates beatae sunt quas quaerat fugit, doloribus excepturi dolorum et eveniet perspiciatis quibusdam harum numquam id! Dolore deleniti nostrum temporibus, quae repellat voluptatibus delectus ad earum ipsam eius quod accusamus assumenda at ipsum commodi dignissimos nesciunt sit laboriosam dolorem vitae. Voluptatibus sed, nemo consequuntur voluptatem maxime eius esse placeat eos, assumenda provident quos dolor porro quo nobis. Enim iusto debitis ullam vero, provident sed maxime suscipit ipsam neque eos tenetur iste vel architecto ducimus quia dignissimos facilis nisi alias harum asperiores excepturi et! Mollitia, necessitatibus, temporibus commodi ab quo ex? Rerum officia molestiae sed nam rem temporibus, delectus eum iusto architecto dicta velit, laboriosam, inventore non vitae qui mollitia unde nihil voluptatem labore commodi? Corrupti, molestias beatae fugiat esse maxime, doloremque tempore hic! Consequatur, quaerat libero exercitationem error ullam veniam aut dolor facere illum animi voluptatibus, pariatur id excepturi, placeat ipsa maiores. Earum eius veritatis sint culpa odit, quas, autem consequatur explicabo molestias tenetur aperiam tempora itaque? A unde molestias non dolores aperiam consequatur reiciendis at numquam officiis quo quam soluta fuga itaque tempore corrupti repellat aliquid, harum mollitia ipsam rem! Accusamus architecto quidem incidunt magni recusandae omnis excepturi aspernatur voluptatum autem, eligendi a esse alias possimus veniam voluptates nam enim officia, asperiores facilis dolores quas perferendis? Temporibus fuga, repellat praesentium quisquam id facere. Accusamus nisi molestias neque, mollitia porro voluptatum similique! Obcaecati ipsum quas sapiente consequuntur nisi est fuga aut, maxime. Vitae, aliquam vero magnam officiis maiores molestias sapiente quidem nihil expedita illum earum fugit autem, quos rem voluptatem sed praesentium dolorum eligendi minus amet, consectetur tempora. Quae animi, quis quos, architecto perspiciatis magnam possimus quas iusto, ut, totam vero similique voluptate nulla? Quo labore maxime, delectus laborum voluptate neque placeat culpa fuga porro voluptas quas unde amet deserunt voluptatibus molestias, fugiat a repudiandae tempora repellendus veritatis numquam sed molestiae doloribus necessitatibus! Ipsam, ipsum eos, excepturi modi odio error alias ab omnis qui. Ut laboriosam, ipsam neque dolorem impedit cum modi maiores iste dolorum non nulla provident inventore velit! Accusamus, voluptates esse impedit, quis, at quod ex non quaerat ab ut incidunt quasi qui dolore molestias rem quas provident nostrum recusandae. Placeat, vitae quam vero? Dignissimos mollitia odit, asperiores odio praesentium, architecto tenetur enim iste consequatur possimus incidunt. Magnam culpa unde expedita laboriosam quae optio earum cumque deserunt, sunt, odio, inventore! Dolorum qui magni quos voluptate! Cupiditate asperiores impedit a blanditiis assumenda rem labore iusto, minima vero eveniet incidunt nobis quisquam laboriosam sapiente at explicabo autem officia earum expedita sint rerum fuga non fugit aliquam. Cupiditate voluptatem quaerat perspiciatis iste vero rerum quo at, rem, quae consectetur eveniet blanditiis esse eos ullam dolore illum deleniti, maxime dicta consequatur.
                      </p>

                        <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
		props: {
      booking: Object,
      published_booking: Object,
      resource_types: Array,
			action: String,
			category: String,
			addBooking: Function,
			updateBooking: Function,
      fetchBookings: Function,
      closeModal: Function,
		},
    data(){
      return {
        resource : {
          title: '',
          resource_type: '',
          booking_sheet_id: this.published_booking.id,
          business_hours: ''
        },
        resourceAction: 'add'
      }
    },
    methods: {
      saveBusinessHours: function(){
        console.log(new Date(this.published_booking.business_hours.start).getHours())
        var event = new Date(this.published_booking.business_hours.start).getTime();
      },
      showResourceCreateForm: function(){
        console.log(this.published_booking)
            this.resourceAction = "add"
            // this.category = "Create Resource Type"
            this.resource = {
              title: '',
              resource_type: '',
              booking_sheet_id: this.published_booking.id,
              business_hours: ''
            }
          },
      viewResourceType: function(index){
        this.resource = this.published_booking.resources[index]
      },
      showEditResourceForm: function(index){
        this.resourceAction = "edit"
        // this.category = "Edit Resource"
        this.resource = this.published_booking.resources[index]
        console.log(this.published_booking);
      },
      addResource: function(){
        axios.post('/api/courtbooking/resource', this.resource).then(res => {
          console.log(res.data)
            if(res.data.success == true) {
              this.published_booking.resources = res.data.published_booking.resources
              // Flash success message
              toastr.success('Resource Added Successfully.')
              // this.$emit('fetchBookings')
              this.closeModal()
            }

            if(res.data.success == false) {
              this.errors = []
              for(let error of res.data.errors) {
                toastr.error(error)
                this.errors.push(error)
              }
            }
        })
        .catch(err => {
          console.log(err)
        });
      },
      updateResource: function(){
        axios.put(`/api/courtbooking/resource/${this.resource.id}`, this.resource)
        .then(res =>{
          console.log(res.data)
          if(res.data.success == true) {
            this.published_booking.resources = res.data.published_booking.resources
            // Flash success message
            toastr.success('Resource Updated Successfully')
            // this.$emit('fetchBookings')
            this.closeModal()
          }

          if(res.data.success == false) {
            this.errors = []
            for(let error of res.data.errors) {
              toastr.error(error)
              this.errors.push(error)
            }
          }

        })
        .catch(err => console.log(err));
      },
      removeResource: function(resource_id){
        let self = this;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this resource',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                // this.$Progress.start()
                axios.delete(`/api/courtbooking/resource/${resource_id}`, {params: this.published_booking})
                .then(res => {
                  console.log(res.data)
                    if( res.data.success == true ){
                        this.published_booking.resources = res.data.published_booking.resources
                        toastr.success("Resource Deleted Successfully")
                        self.fetchBookings()
                        // this.$Progress.finish()
                    }
                }).catch(err => {
                    // this.$Progress.start()
                    this.displayError(err.response)
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        });
      },
      closeSettingModal: function(){
        console.log(this.published_booking)
        Vue.delete(this.published_booking, 'isActiveSettingModel')
        this.published_booking.isActiveSettingModel = false
      }
    }
  }
</script>
<style scoped="scoped">
  #settingBookingSheetModal .modal-dialog {
    max-width: 80%;
    margin: 0px;
    margin-left: auto;
  }
  .add-btn{
    padding: 0px 15px;
    height: 40px;
    line-height: 40px;
    align-self: center;
    margin-right: 15px;
    background-color:#fff;
    border-color:#fff;
    color:#2a2a2a;
  }
</style>