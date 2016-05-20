<?php

namespace TyrSynchroBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use CanalTP\TyrComponent\TyrService;

class FenrirInitFromTyrCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fenrir:init-from-tyr')
            ->setDescription('This command will remove all data in current database and fetch all users from tyr api.')
            ->addArgument('tyr_url', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    private function saveUsersFromTyr(InputInterface $input, OutputInterface $output)
    {
        $origins = [];
        $tyrService = new TyrService($input->getArgument('tyr_url'));
        $userManager = $this->getContainer()->get('core.service.user');
        $originManager = $this->getContainer()->get('core.service.origin');
        $users = $tyrService->getUsers();
        $response = $tyrService->getLastResponse();

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Tyr url "' . $input->getArgument('tyr_url') . '" is not correct', 1);
        }
        foreach ($users as $user) {
            if (!array_key_exists($user->end_point->id, $origins)) {
                $origins[$user->end_point->id] = $originManager->create($user->end_point->name);
            }
            $userArray = json_decode(json_encode($user), true);
            $userArray['username'] = $userArray['login'];
            $userArray['originId'] = $origins[$user->end_point->id]->getId();
            $userManager->create($userArray);
        }
        $output->writeln('<info>Congrats ! ' . count($users) . ' users added in fenrir database.</info>');
    }

    private function dropSchemaDatabase(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:schema:drop');
        $arguments = array(
            'command' => 'doctrine:schema:drop',
            '--force' => true
        );

        $input = new ArrayInput($arguments);

        $command->run($input, $output);
    }

    private function updateSchemaDatabase(OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:schema:update');
        $arguments = array(
            'command' => 'doctrine:schema:update',
            '--force' => true
        );

        $input = new ArrayInput($arguments);

        $command->run($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            'This command will remove all data in database. Continue ? (y/N) ',
            false
        );

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('Canceled.');
            return;
        }
        $this->dropSchemaDatabase($output);
        $this->updateSchemaDatabase($output);
        $this->saveUsersFromTyr($input, $output);
    }

}
