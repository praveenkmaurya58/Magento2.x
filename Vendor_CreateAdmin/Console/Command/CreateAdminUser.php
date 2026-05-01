<?php
/** 
 * Console command to create admin user for Vendor_CreateAdmin module       
 */ 
namespace Vendor\CreateAdmin\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\State;
use Vendor\CreateAdmin\Helper\AdminHelper;
use Vendor\CreateAdmin\Helper\Logger;

/** 
 * Console command to create admin user for Vendor_CreateAdmin module       
 */
class CreateAdminUser extends Command
{
    /** @var AdminHelper */
    protected $adminHelper;
    /** @var State */
    private $state;
    /** @var Logger */
    protected $_logger;

    /** 
     * Constructor to initialize the console command
     * @param AdminHelper $adminHelper
     * @param State $state
     * @param Logger $logger
     */
    public function __construct(AdminHelper $adminHelper,State $state, Logger $logger)
    {
        $this->adminHelper = $adminHelper;
        $this->state=$state;
        $this->_logger=$logger;
        parent::__construct();
    }

    /** 
     * Configure the console command
     */
    protected function configure()
    {
        $this
            ->setName('vendor:user:admin')
            ->setDescription('Create Admin User')
            ->setDefinition([
                new InputOption(AdminHelper::ADMIN_USERNAME, '-u', InputOption::VALUE_REQUIRED, '(Required) User name'),
                new InputOption(AdminHelper::ADMIN_FIRSTNAME, '-f', InputOption::VALUE_REQUIRED, '(Required) First name'),
                new InputOption(AdminHelper::ADMIN_LASTNAME, '-l', InputOption::VALUE_REQUIRED, '(Required) Last name'),
                new InputOption(AdminHelper::ADMIN_EMAIL, '-e', InputOption::VALUE_REQUIRED, '(Required) Email'),
                new InputOption(AdminHelper::ADMIN_PASSWORD, '-p', InputOption::VALUE_REQUIRED, '(Required) Password'),
            ]);
        parent::configure();
    }

    /** 
     * Execute the console command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $output->writeln('<info>Creating new Admin User</info>');
        $this->adminHelper->setData($input);
        try{
            $adminUser = $this->adminHelper->execute();
        }
        catch (Exception $e){
            $this->_logger->error($e->getMessage());
        }

        // To print the admin information If Admin User will create

        if ($adminUser && $adminUser->getId()) {
            $output->writeln("<info>New Admin User Created</info>");
            $output->writeln((string) __("ID: %1", $adminUser->getId()));
            $output->writeln((string) __("User Name: %1", $adminUser->getUsername()));
            $output->writeln((string) __("First name: %1", $adminUser->getFirstname()));
            $output->writeln((string) __("Last name: %1", $adminUser->getLastname()));
            $output->writeln((string) __("Email: %1", $adminUser->getEmail()));

        } else {
            $output->writeln("<error>Problem creating new user</error>");

        }
    }

}
