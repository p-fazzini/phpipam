<?php

print "<h4>"._('BGP Routing details')."</h4>";
print "<hr>";

# circuit
print "<table class='ipaddress_subnet table-condensed table-auto'>";

print '<tr>';
print " <th>". _('Peer name').'</th>';
print " <td><strong>$bgp->peer_name</strong></td>";
print "</tr>";

print '<tr>';
print " <th>". _('BGP type').'</th>';
print " <td>$bgp->bgp_type</td>";
print "</tr>";

if ($User->settings->enableCustomers=="1") {
print '<tr>';
print " <th>". _('Customer').'</th>';
    if($customer===false) {
        print " <td>/</td>";
    }
    else {
        print " <td>$customer->title <a target='_blank' href='".create_link("tools","customers",$customer->title)."'><i class='fa fa-external-link'></i></a></td>";
    }
print "</tr>";
}

if ($User->settings->enableCircuits=="1") {
print '<tr>';
print " <th>". _('Circuit').'</th>';
    if($circuit===false) {
        print " <td>/</td>";
    }
    else {
        print " <td>$circuit->cid <a target='_blank' href='".create_link("tools","circuits",$circuit->id)."'><i class='fa fa-external-link'></i></a></td>";
    }
print "</tr>";
}

if ($User->settings->enableVRF=="1") {
print '<tr>';
print " <th>". _('VRF').'</th>';
    if($vrf===false) {
        print " <td>/</td>";
    }
    else {
        print " <td>$vrf->name <a target='_blank' href='".create_link("tools","vrf",$vrf->vrfId)."'><i class='fa fa-external-link'></i></a></td>";
    }
print "</tr>";
}

print '<tr>';
print " <th>". _('Description').'</th>';
print " <td>$bgp->description</td>";
print "</tr>";


print "<tr>";
print " <td colspan='2'><hr></td>";
print "</tr>";

print '<tr>';
print " <th>". _('Local AS').'</th>';
print " <td>$bgp->local_as</td>";
print "</tr>";

print '<tr>';
print " <th>". _('Local address').'</th>';
print " <td>$bgp->local_address</td>";
print "</tr>";

print "<tr>";
print " <td colspan='2'><hr></td>";
print "</tr>";

print '<tr>';
print " <th>". _('Peer AS').'</th>';
print " <td>$bgp->peer_as</td>";
print "</tr>";

print '<tr>';
print " <th>". _('Peer address').'</th>';
print " <td>$bgp->peer_address</td>";
print "</tr>";



if(sizeof($custom_bgp) > 0) {
    print "<tr>";
    print " <td colspan='2'><hr></td>";
    print "</tr>";

    foreach($custom_bgp as $field) {
        $bgp->{$field['name']} = $Tools->process_field ($bgp->{$field['name']}, $field['type']);

        print "<tr>";
        print "<th>".$Tools->print_custom_field_name ($field['name'])."</th>";
        print "<td>".$bgp->{$field['name']}."</d>";
        print "</tr>";
    }
}

// edit, delete
if($User->get_module_permissions ("routing")>=User::ACCESS_RW) {
    print "<tr>";
    print " <td colspan='2'><hr></td>";
    print "</tr>";

    print "<tr>";
    print " <td></td>";
    print " <td class='actions'>";

    $links = [];
    if($User->get_module_permissions ("routing")>=User::ACCESS_RW) {
        $links[] = ["type"=>"header", "text"=>_("Manage BGP")];
        $links[] = ["type"=>"link", "text"=>_("Edit BGP"), "href"=>"", "class"=>"open_popup", "dataparams"=>"data-script='app/admin/routing/edit-bgp.php' data-action='edit' data-class='700' data-bgpid='$bgp->id'", "icon"=>"pencil"];
    }
    if($User->get_module_permissions ("routing")>=User::ACCESS_RWA) {
        $links[] = ["type"=>"link", "text"=>_("Delete BGP"), "href"=>"", "class"=>"open_popup", "dataparams"=>"data-script='app/admin/routing/edit-bgp.php' data-action='delete' data-class='700' data-bgpid='$bgp->id'", "icon"=>"times"];
        $links[] = ["type"=>"link", "text"=>_("Subnet mapping"), "href"=>"", "class"=>"open_popup", "dataparams"=>"data-script='app/admin/routing/edit-bgp-mapping.php' data-class='700' data-secondary='true' data-bgpid='$bgp->id'",  "icon"=>"plus"];
        $links[] = ["type"=>"divider"];
    }
    // print links
    print $User->print_actions($User->user->compress_actions, $links, true, true);
    print "</td>";

    print " </td>";
    print "</tr>";
}

print "</table>";
