<?php

namespace laspi94\CsgoServerApi\Tests\Unit\Lists;

use laspi94\CsgoServerApi\Classes\Command;
use laspi94\CsgoServerApi\Classes\Lists\CommandList;
use laspi94\CsgoServerApi\Tests\Base;

class CommandListTest extends Base
{
	public function test_command_list_will_add_new_commands()
	{
		$commandList = new CommandList();

		$commandList->addItem(new Command('stats', 1000, false));
		$commandList->addItem([
			new Command('stats', 1500, false),
			new Command('status', 1500, false),
		]);

		$commandList->addItem('stats', 1500, false);

		$commandList->addItem([
			['stats', '1500', false],
			['status', '1500', false],
		]);

		$this->assertEquals(6, count($commandList->getList()));
	}
}