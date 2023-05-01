<template>
  <div>
    <div class="add_talk">
      <h1>Add Slots</h1>
      <hr />

      <div
        class="slots_wrapper"
        style="display: flex; justify-content: space-around"
      >
        <div>
          <ul>
            <li class="slots_card" v-for="slot in slots" :key="slot.id">
              <div style="display: flex; justify-content: space-between">
                <div>
                  <b
                    ><p>{{ slot.name }}</p></b
                  >
                  <p>{{ slot.from }} - {{ slot.to }}</p>
                </div>

                <div>
                  <p :class="'slot_type slot_type_' + slot.talk_type">
                    {{ slot.talk_type }}
                  </p>
                  <el-popover
                    placement="top"
                    width="160"
                    v-model="slot.visible"
                  >
                    <p>Confirm delete this?</p>
                    <div style="text-align: right; margin: 0">
                      <el-button
                        size="mini"
                        type="text"
                        @click="() => (slot.visible = false)"
                        >cancel</el-button
                      >
                      <el-button
                        type="primary"
                        size="mini"
                        @click="
                          () => {
                            remove(slot)
                            slot.visible = false
                          }
                        "
                        >confirm</el-button
                      >
                    </div>

                    <a slot="reference" style="cursor: pointer">delete</a>
                  </el-popover>
                  | <a style="cursor: pointer" @click="edit(slot)">edit</a>
                </div>
              </div>
              <div>
                <ul
                  style="
                    display: flex;
                    flex-wrap: nowrap;
                    justify-content: flex-start;
                  "
                >
                  <li
                    style="font-style: italic; font-size: 12px"
                    v-for="speaker in slot.speakers"
                    :key="speaker"
                  >
                    {{ getName(speaker) }},
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          <el-button @click="create">+ Add slot</el-button>
        </div>
        <div>
          <h3>Slot Info</h3>
          <table class="slot_info">
            <thead>
              <tr style="text-align: left">
                <th>Talk Type</th>
                <th>Count</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Panel (45 mins)</td>
                <td>
                  {{ slots.filter(item => item.talk_type === 'panel').length }}
                </td>
              </tr>
              <tr>
                <td>Keynote (30 mins)</td>
                <td>
                  {{
                    slots.filter(item => item.talk_type === 'keynote').length
                  }}
                </td>
              </tr>
              <tr>
                <td>Semi Keynote (20 mins)</td>
                <td>
                  {{
                    slots.filter(item => item.talk_type === 'semi-keynote')
                      .length
                  }}
                </td>
              </tr>
              <tr>
                <td>Lightning (10 mins)</td>
                <td>
                  {{
                    slots.filter(item => item.talk_type === 'lightning').length
                  }}
                </td>
              </tr>
              <tr>
                <td>
                  <hr />
                  Total Slots
                </td>
                <td>{{ slots.length }}</td>
              </tr>
            </tbody>
          </table>
          <h3>Speaker Info</h3>
          <table>
            <p>Total Speakers: {{ getTotalSpeakers() }}</p>
          </table>
        </div>
      </div>
    </div>
    <el-dialog title="Tips" :visible.sync="dialogVisible" width="70%">
      <el-form>
        <el-form ref="form" :model="form" label-width="120px">
          <el-form-item label="Talk title">
            <el-autocomplete style="min-width:450px;"
              v-model="form.name"
              :fetch-suggestions="querySearchAsync"
              placeholder="Please input"
              @select="handleSelect"
            ></el-autocomplete>
          </el-form-item>
          <!-- <el-form-item label="Talk title">
            <el-input v-model="form.name"></el-input>
          </el-form-item> -->
          <el-form-item label="Talk type">
            <el-select
              v-model="form.talk_type"
              placeholder="please select your type"
            >
              <el-option
                v-for="slot in talkTypes"
                :key="slot.slug"
                :label="slot.name"
                :value="slot.slug"
              ></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="Talk time">
            <el-col :span="24">
              <el-time-select
                placeholder="Start time"
                v-model="form.from"
                format="HH:mm A"
                :picker-options="{
                  start: '08:00',
                  step: '00:05',
                  end: '18:30'
                }"
              >
              </el-time-select>
              <el-time-select
                placeholder="End time"
                v-model="form.to"
                :picker-options="{
                  start: '08:00',
                  step: '00:05',
                  end: '18:30',
                  minTime: '07:00'
                }"
              >
              </el-time-select>
            </el-col>
          </el-form-item>
          <el-form-item label="Speakers">
            <el-col>
              <el-select
                style="min-width: 430px"
                v-model="form.speakers"
                multiple
                filterable
                allow-create
                default-first-option
                placeholder="Choose tags for your article"
              >
                <el-option
                  v-for="item in speakers"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </el-col>
          </el-form-item>
        </el-form>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="addNew">Confirm</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data () {
    return {
      dialogVisible: false,
      form_mock: {
        name: '',
        talk_type: '',
        from: '',
        to: ''
      },
      form: {
        name: '',
        talk_type: '',
        from: '',
        to: ''
      },
      talkTypes: [
        {
          name: 'Panel',
          description: 'Panel',
          slug: 'panel',
          duration: '45'
        },
        {
          name: 'Keynote',
          description: 'Keynote',
          slug: 'keynote',
          duration: '30'
        },
        {
          name: 'Semi Keynote',
          description: 'semi Keynote',
          slug: 'semi-keynote',
          duration: '20'
        },
        {
          name: 'Lightning Talk',
          description: 'Lightning Talk',
          slug: 'lightning',
          duration: '10'
        },
        {
          name: 'Break',
          description: 'Break Time',
          slug: 'break',
          duration: '-'
        }
      ],
      slots: [],
      speakers: window.speakersAdmin.speakers
    }
  },
  methods: {
    handleSelect (item) {
      this.form.name = item.value
    },
    debounce (func, delay) {
      let timerId
      return function (...args) {
        if (timerId) {
          clearTimeout(timerId)
        }
        timerId = setTimeout(() => {
          func.apply(this, args)
        }, delay)
      }
    },
    querySearchAsync (queryString, cb) {
        const debouncedMethod = this.debounce(this.searchTitle(queryString, cb), 1500);
        debouncedMethod();
    },
    searchTitle (queryString, cb) {
      this.$get({
        action: 'speakers_admin_ajax',
        route: 'search_speakers',
        search_by: queryString
      }).then(response => {
        cb(response)
      })
    },
    create () {
      this.form = Object.assign({}, this.form_mock)
      this.dialogVisible = true
    },
    addNew () {
      this.$post({
        action: 'speakers_admin_ajax',
        route: 'save_slots',
        data: this.form
      }).then(response => {
        this.dialogVisible = false
        this.fetch()
      })
    },
    getTotalSpeakers () {
      let count = 0
      this.slots.forEach(element => {
        count += element.speakers ? element.speakers.length : 0
      })
      return count
    },
    getName (id) {
      const speaker = this.speakers.find(speaker => speaker.id === id)
      return speaker?.name
    },
    remove (slot) {
      this.$post({
        action: 'speakers_admin_ajax',
        route: 'delete_slot',
        id: slot.id
      }).then(response => {
        this.fetch()
      })
    },
    edit (slot) {
      this.form = slot
      this.dialogVisible = true
    },
    fetch () {
      this.$get({
        action: 'speakers_admin_ajax',
        route: 'get_slots'
        // options: {
        // //   not_status: ['rejected', 'approved']
        // }
      }).then(response => {
        this.slots = response.data
      })
    }
  },
  mounted () {
    this.fetch()
  }
}
</script>

<style lang="scss">
li.slots_card {
  border: 1px solid #ccc;
  width: 500px;
  padding: 10px 23px;
  border-radius: 12px;
}

p.slot_type {
  padding: 2px 9px;
  color: white;
  border-radius: 5px;
  &_panel {
    background: #eb3006;
  }
  &_keynote {
    background: #e78608;
  }
  &_semi-keynote {
    background: #93651f;
  }
  &_lightning {
    background: #67c23a;
  }
  &_break {
    background: #909399;
  }
}
</style>
