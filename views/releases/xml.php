<?= $xml_header ?>

<release>
    <album_action>
        <?php if ($release['ftp_status'] === '0'): ?>insert<?php endif; ?>
        <?php if ($release['ftp_status'] === '1'): ?>updated<?php endif; ?>
        <?php if ($release['ftp_status'] === '2'): ?>deleted<?php endif; ?>
    </album_action>
    <aggregatorName>NV Media LLC</aggregatorName>
    <labelName><?= $release['label'] ?></labelName>
    <UPC_EAN><?= $release['upc_code'] . ' / ' . $release['ean_code'] ?></UPC_EAN>
    <catalogNumber><?= $release['catalog'] ?></catalogNumber>
    <coverArtFilename><?= $release['cover_image'] ?></coverArtFilename>
    <releaseTitle><?= $release['title'] ?></releaseTitle>
    <releaseDescription><?= $release['description'] ?></releaseDescription>
    <tracks>
        <?php foreach ($release['tracks'] as $key => $value): ?>
            <track>
            <albumOnly>0</albumOnly>
            <trackNumber><?= $value['id'] ?></trackNumber>
            <ISRC>US5UL1823318</ISRC>
            <?php if (!empty( $release['published_by'])):?>
                    <trackPublisher><?= $release['published_by'] ?></trackPublisher>
                <?php else:?>
                    <trackPublisher>copyright control</trackPublisher>
            <?php endif;?>
            <trackTitle><?= $value['track_title'] ?></trackTitle>
            <trackMixVersion><?= $value['mix_name'] ?></trackMixVersion>
            <originalReleaseDate>2020-01-15</originalReleaseDate>
            <beatportExclusive>
                <exclusivePeriod>0</exclusivePeriod>
            </beatportExclusive>
            <trackArtists>
                <artistName><?= $value['track_artist'] ?></artistName>
            </trackArtists>
            <trackAudioFile>
                <audioFilename><?= $value['track'] ?></audioFilename>
            </trackAudioFile>

            <?php if (!empty($release['territory_selection'])): ?>
                <countriesAvailable>
                    <?php foreach ($country as $kk => $vv):?>
                        <country><?= $vv['iso']?></country>
                    <?php endforeach;?>

                </countriesAvailable>
            <?php else: ?>
                <countriesAvailable>
                    <country>WW</country>
                </countriesAvailable>
            <?php endif; ?>

            <trackGenre><?= $release['primary_genre'] ?></trackGenre>
            <trackCopyright><?= $release['author_name'] . ' ' . $release['author_lastname'] ?></trackCopyright>
            <songwriters>
                <songwriter>
                    <name>Above Envy</name>
                </songwriter>
            </songwriters>
            </track>
        <?php endforeach; ?>
    </tracks>
</release>
