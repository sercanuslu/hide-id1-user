# Hide ID1 User - WordPress Eklentisi

## Açıklama
Bu eklenti, belirli kullanıcıların WordPress yönetim panelinde listelenmesini ve düzenlenmesini engellemek için geliştirilmiştir. Kullanıcı listeleme sorgularını filtreleyerek ID'si 1 olan kullanıcıyı hariç tutar ve bu kullanıcının profilinin düzenlenmesini sınırlar.

## Özellikler
- **Kullanıcı listeleme engelleme**: ID'si 1 olan kullanıcı, kullanıcı listesinde gösterilmez.
- **Profil düzenleme sınırlandırma**: ID'si 1 olan kullanıcı için profil düzenleme işlemleri engellenir.
- **WordPress Hook ve Filtreler** kullanılarak esnek ve optimize edilmiş bir yapı sunar.
- **Dil desteği (i18n) hazırdır**: Çevirilere uygun bir yapıya sahiptir.

## Kullanılan Hook ve Filtreler

### Action'lar
- **pre_user_query**: Kullanıcı listeleme sorgularını filtrelemek için kullanılır.
- **load-user-edit.php**: Kullanıcı düzenleme sayfasına erişimi engeller.
- **load-profile.php**: Kullanıcı kendi profilini düzenlemeye çalışırken erişimi sınırlar.
- **edit_user_profile_update** ve **personal_options_update**: Kullanıcı profili güncellemelerini engeller.

### Filtreler
- **users_list_table_query_args** ve **get_users_args**: Kullanıcı sorgularında ID’si 1 olan kullanıcıyı hariç tutar.

## Kullanım Örnekleri

### Kullanıcı Listeleme Engelleme
```php
function hide_user_srcn_from_list($query) {
    if (is_admin() && current_user_can('list_users')) {
        global $wpdb;
        $query->query_where .= $wpdb->prepare(" AND {$wpdb->users}.ID != %d", 1);
    }
}
add_action('pre_user_query', 'hide_user_srcn_from_list');
```

### Profil Güncelleme Engelleme
```php
function prevent_user_id_1_editing($user_id) {
    if (absint($user_id) === 1) {
        wp_die(__('Bu kullanıcı güncellenemez.', 'hide-user-srcn'), __('Erişim Engellendi', 'hide-user-srcn'), 403);
    }
}
add_action('edit_user_profile_update', 'prevent_user_id_1_editing');
```

## Dil Desteği
Bu eklenti **uluslararasılaştırma (i18n)** için hazırdır. POT dosyasını oluşturup dil çevirilerini ekleyebilirsiniz.

## Kurulum
1. Eklentiyi **WordPress eklenti dizinine** yükleyin.
2. WordPress yönetim panelinden **Eklentiler > Yüklü Eklentiler** bölümüne gidin.
3. **Hide User SRCN** eklentisini etkinleştirin.
4. Eklenti otomatik olarak çalışacaktır. Herhangi bir ek ayara gerek yoktur.

## Lisans
Bu eklenti **GPL v2 veya üzeri** lisansı ile dağıtılmaktadır.

---

📌 **Geliştirici**: Sercan USLU  
🔗 **Websitesi**: [wordpres.tr](https://wordpres.tr/id-1-kullanicisini-gizle/)
