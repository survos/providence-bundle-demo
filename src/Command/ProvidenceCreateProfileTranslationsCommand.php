<?php

namespace App\Command;

use Survos\Providence\Services\ProfileService;
use Survos\Providence\XmlModel\XmlProfile;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(
    name: 'providence:create-profile-translations',
    description: 'Extract the labels from the profile xml into Symfony Translation files',
)]
class ProvidenceCreateProfileTranslationsCommand extends Command
{

    public function __construct(private ProfileService $profileService,
                                private ParameterBagInterface $bag,
                                string $name=null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        /** @var XmlProfile $xmlProfile */
        foreach ($this->profileService->getXmlProfiles() as $xmlProfile) {
            $labels = $this->profileService->loadLabelsFromXml($xmlProfile);
            foreach ($labels as $locale=>$translations) {
                $yaml = Yaml::dump($translations);
                $filename = $this->bag->get('kernel.project_dir') . sprintf('/translations/%s+intl-icu.%s.yaml', $xmlProfile->getProfileId(), $locale);
                file_put_contents($filename, $yaml);
                $io->note($filename . ' written with '. count($translations) . ' translations');
            }

        }

        $io->success('Finished');

        return Command::SUCCESS;
    }
}
