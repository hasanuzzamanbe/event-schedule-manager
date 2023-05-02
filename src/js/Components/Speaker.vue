<template>
  <div>
    <div style="display: flex; justify-content: flex-end">
      <p style="margin-right: 12px">Person: {{ eventSpeechOrganizer.length }}</p>

      <!-- download csv -->
      <el-button
        class="speaker-action-button"
        type="primary"
        icon="el-icon-download"
        size="mini"
        @click="downloadCSV"
        >download CSV</el-button
      >

      <el-button
        class="speaker-action-button"
        type="success"
        size="mini"
        @click="add"
        >Add Applicant</el-button
      >
    </div>

    <div v-if="!eventSpeechOrganizer.length">No person in this list!</div>
    <ul class="eventSpeechOrganizer">
      <li
        class="speaker_applicant"
        v-for="(speaker, i) in eventSpeechOrganizer"
        :key="speaker.id"
      >
        <div class="profile-section">
          <div class="profile-left-col">
            <h3>{{ speaker.id }}. {{ speaker.name }}</h3>
            <i
              class="el-icon-edit"
              style="cursor: pointer; margin-top: 15px"
              @click="editApplicant(speaker)"
            ></i>
            <span class="applied-at">{{ speaker.date }}</span
            ><br />
            <a :href="'mailto:' + speaker.email">{{ speaker.email }}</a
            ><br />
            <a :href="'tel:' + speaker.phone">{{ speaker.phone }}</a
            ><br />
            <a target="_blank" :href="speaker.social">{{ speaker.social }}</a
            ><br />
            <a target="_blank" :href="getWpProfile(speaker)"
              >WP: {{ speaker.username }}</a
            >
          </div>

          <div class="profile-right-col">
            <img
              class="avatar"
              :src="get_gravatar_image_url(speaker.email, '96')"
              alt=""
            />
          </div>
        </div>

        <div style="display: flex; justify-content: space-between">
          <el-button-group style="margin-top: 12px">
            <el-button
              plain
              type="primary"
              size="mini"
              @click="updateStatus(speaker, 'approved')"
            >
              approve
            </el-button>
            <el-button
              plain
              type="danger"
              size="mini"
              @click="updateStatus(speaker, 'rejected')"
            >
              reject
            </el-button>
            <el-button
              plain
              type="info"
              size="mini"
              @click="updateStatus(speaker, 'waiting')"
            >
              waitlist
            </el-button>
          </el-button-group>

          <p :class="'application-status-' + speaker.status">
            {{ speaker.status }}
          </p>
        </div>

        <div v-if="speaker.showBio">
          <p>{{ speaker.comment }}</p>
          <p class="action" @click="hideBio(speaker)">hide ^</p>
        </div>
        <div
          v-else
          style="margin-top: 12px"
          class="action"
          @click="viewBio(speaker, i)"
        >
          view bio
        </div>

        <h4>{{ speaker.topic }}</h4>

        <div v-if="speaker.viewDesc">
          <p>{{ speaker.description }}</p>
          <p>{{ speaker.type }}</p>
          <p>Co-eventSpeechOrganizer:{{ speaker.coeventSpeechOrganizer }}</p>
          <p>Audience: {{ speaker.audience }}</p>
          <p>Experience: {{ speaker.experience }}</p>
          <p class="action" @click="hideDesc(speaker)">hide ^</p>
        </div>
        <div v-else class="action" @click="viewDesc(speaker)">
          view topic details
        </div>
      </li>
    </ul>

    <!-- speaker-modal -->
    <el-dialog title="Add Applicant" :visible.sync="speakerModal" width="70%">
      <el-form v-model="speakerNew">
        <el-form-item label="Application date">
          <el-input
            v-model="speakerNew.date"
            placeholder="Application date-time"
          ></el-input>
        </el-form-item>
        <el-form-item label="Name">
          <el-input v-model="speakerNew.name" placeholder="Name"></el-input>
        </el-form-item>
        <el-form-item label="Email">
          <el-input v-model="speakerNew.email" placeholder="Email"></el-input>
        </el-form-item>
        <el-form-item label="Phone">
          <el-input v-model="speakerNew.phone" placeholder="Phone"></el-input>
        </el-form-item>
        <el-form-item label="Username">
          <el-input
            v-model="speakerNew.username"
            placeholder="Username"
          ></el-input>
        </el-form-item>
        <el-form-item label="Applicant bio">
          <el-input
            type="textarea"
            v-model="speakerNew.comment"
            placeholder="Your bio"
          ></el-input>
        </el-form-item>
        <el-form-item label="Social handles">
          <el-input
            type="textarea"
            v-model="speakerNew.social"
            placeholder="Social"
          ></el-input>
        </el-form-item>
        <el-form-item label="Talk type">
          <el-input v-model="speakerNew.type" placeholder="Type"></el-input>
        </el-form-item>
        <el-form-item label="Topic title">
          <el-input
            v-model="speakerNew.topic"
            placeholder="Topic Title"
          ></el-input>
        </el-form-item>
        <el-form-item label="Description">
          <el-input
            type="textarea"
            v-model="speakerNew.description"
            placeholder="Description"
          ></el-input>
        </el-form-item>
        <el-form-item label="Co-eventSpeechOrganizer">
          <el-input
            type="textarea"
            v-model="speakerNew.coeventSpeechOrganizer"
            placeholder="Co-eventSpeechOrganizer"
          ></el-input>
        </el-form-item>
        <el-form-item label="audience">
          <el-input
            v-model="speakerNew.audience"
            placeholder="Audience"
          ></el-input>
        </el-form-item>
        <el-form-item label="Experience">
          <el-input
            type="textarea"
            v-model="speakerNew.experience"
            placeholder="Experience"
          ></el-input>
        </el-form-item>
        <el-button type="info" @click="speakerModal = false">cancel</el-button>
        <el-button type="primary" @click="addOrUpdate">save</el-button>
      </el-form>
    </el-dialog>
  </div>
</template>
<script>
var md5 = require('md5')
export default {
  data () {
    return {
      speakerModal: false,
      speakerFormMock: {
        date: '',
        name: '',
        email: '',
        phone: '',
        social: '',
        username: '',
        comment: '',
        topic: '',
        description: '',
        type: '',
        coeventSpeechOrganizer: '',
        audience: '',
        experience: '',
        status: 'waiting'
      },
      speakerNew: {}
    }
  },
  props: {
    eventSpeechOrganizer: {
      type: Array,
      required: true
    }
  },
  methods: {
    editApplicant (speaker) {
      this.speakerModal = true
      this.speakerNew = { ...speaker }
    },
    add () {
      this.speakerModal = true
      this.speakerNew = { ...this.speakerFormMock }
    },
    addOrUpdate () {
      if (this.speakerNew.id) {
        this.$post({
          action: 'event_speech_organizer_admin_ajax',
          route: 'edit_applicant',
          data: this.speakerNew
        }).then(response => {
          this.speakerModal = false
          this.$emit('fetch')
        })
        return
      }

      this.$post({
        action: 'event_speech_organizer_admin_ajax',
        route: 'add_applicant',
        data: this.speakerNew
      }).then(response => {
        this.speakerModal = false
        this.$emit('fetch')
      })
    },
    downloadCSV () {
      let emails = []
      this.eventSpeechOrganizer.forEach(speaker => {
        emails.push([speaker.name, speaker.email])
      })

      let csvContent = 'name,email\r\n'

      emails.forEach(function (rowArray) {
        let row = rowArray.join(',')
        csvContent += row + '\r\n'
      })

      let filename = this.$route.name
      this.downloadStringAsFile(csvContent, filename + '.csv')
    },
    downloadStringAsFile (text, filename) {
      const blob = new Blob([text], { type: 'text/plain' })
      const url = URL.createObjectURL(blob)
      const link = document.createElement('a')
      link.setAttribute('href', url)
      link.setAttribute('download', filename)
      link.style.display = 'none'
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
      URL.revokeObjectURL(url)
    },
    updateStatus (speaker, status) {
      this.$set(speaker, 'status', status)
      this.$post({
        action: 'event_speech_organizer_admin_ajax',
        route: 'update_status',
        options: {
          id: speaker.id,
          status: status
        }
      }).then(response => {
        this.$emit('fetch')
      })
    },
    getWpProfile (speaker) {
      if (speaker.username.indexOf('@') > -1) {
        return `https://profiles.wordpress.org/${
          speaker.username.split('@')[1]
        }`
      } else if (speaker.username.indexOf('https://') > -1) {
        return speaker.username
      } else {
        return `https://profiles.wordpress.org/${speaker.username}`
      }
    },
    viewBio (speaker, i) {
      this.$set(speaker, 'showBio', true)
    },
    hideBio (speaker) {
      this.$set(speaker, 'showBio', false)
    },
    viewDesc (speaker) {
      this.$set(speaker, 'viewDesc', true)
    },
    hideDesc (speaker) {
      this.$set(speaker, 'viewDesc', false)
    },
    get_gravatar_image_url (
      email,
      size,
      default_image,
      allowed_rating,
      force_default
    ) {
      email = typeof email !== 'undefined' ? email : 'john.doe@example.com'
      size = size >= 1 && size <= 2048 ? size : 80
      default_image =
        typeof default_image !== 'undefined' ? default_image : 'mm'
      allowed_rating =
        typeof allowed_rating !== 'undefined' ? allowed_rating : 'g'
      force_default = force_default === true ? 'y' : 'n'
      return (
        'https://secure.gravatar.com/avatar/' +
        md5(email.toLowerCase().trim()) +
        '?size=' +
        size +
        '&default=' +
        encodeURIComponent(default_image) +
        '&rating=' +
        allowed_rating +
        (force_default === 'y' ? '&forcedefault=' + force_default : '')
      )
    }
  }
}
</script>

<style>
.speaker-action-button {
  margin-left: 12px;
  height: 27px;
}
</style>
